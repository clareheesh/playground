class Errors {
  /**
   * Create a new Errors instance.
   */
  constructor() {
    this.errors = {};
  }


  /**
   * Determine if an errors exists for the given field.
   *
   * @param {string} field
   */
  has(field) {
    return this.errors.hasOwnProperty(field);
  }


  /**
   * Determine if we have any errors.
   */
  any() {
    return Object.keys(this.errors).length > 0;
  }


  /**
   * Retrieve the error message for a field.
   *
   * @param {string} field
   */
  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }


  /**
   * Record the new errors.
   *
   * @param {object} errors
   */
  record(errors) {
    this.errors = errors;
  }


  /**
   * Clear one or all error fields.
   *
   * @param {string|null} field
   */
  clear(field) {
    if (field) {
      delete this.errors[field];

      return;
    }

    this.errors = {};
  }
}


class Form {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  constructor(data) {
    this.originalData = data;

    for (let field in data) {
      this[field] = data[field];
    }

    this.errors = new Errors();
  }


  /**
   * Fetch all relevant data for the form.
   */
  data() {
    let data = {};

    for (let property in this.originalData) {
      data[property] = this[property];
    }

    return data;
  }


  /**
   * Update the data in the form
   */
  load(data) {
    for (let property in data) {
      this[property] = data[property];
    }
  }


  /**
   * Reset the form fields.
   */
  reset() {
    for (let field in this.originalData) {
      this[field] = '';
    }

    this.mode = 'new';
    this.errors.clear();
  }


  /**
   * Send a POST request to the given URL.
   * .
   * @param {string} url
   */
  post(url) {
    return this.submit('post', url);
  }


  /**
   * Send a PUT request to the given URL.
   * .
   * @param {string} url
   */
  put(url) {
    return this.submit('put', url);
  }


  /**
   * Send a PATCH request to the given URL.
   * .
   * @param {string} url
   */
  patch(url) {
    return this.submit('patch', url);
  }


  /**
   * Send a DELETE request to the given URL.
   * .
   * @param {string} url
   */
  delete(url) {
    return this.submit('delete', url);
  }


  /**
   * Submit the form.
   *
   * @param {string} requestType
   * @param {string} url
   */
  submit(requestType, url) {
    return new Promise((resolve, reject) => {
      axios[requestType](url, this.data())
        .then(response => {
          this.onSuccess(response.data);

          resolve(response.data);
        })
        .catch(error => {
          this.onFail(error.response.data);

          reject(error.response.data);
        });
    });
  }


  /**
   * Handle a successful form submission.
   *
   * @param {object} data
   */
  onSuccess() {
    this.reset();
  }


  /**
   * Handle a failed form submission.
   *
   * @param {object} errors
   */
  onFail(errors) {
    this.errors.record(errors);
  }
}

new Vue({
  el: '#dolls-list',

  data: {
    form: new Form({
      name: '',
      priority: '',
      stock: '',
      ideal: '',
      price: '',
      rank: '',
      notes: '',
      etsy_id: ''
    }),
    dolls: {},
    sort: {
      key: 'name',
      order: 'asc'
    },
    mode: 'new',
    totals: {
      stock: 0,
      ideal: 0,
      value: 0
    }
  },

  computed: {
    daysUntil: () => {
      let today = new Date();
      let supanova = new Date(2018, 11, 9);

      return Math.round(Math.abs((today.getTime() - supanova.getTime()) / (24 * 60 * 60 * 1000)))
    }
  },

  created() {
    this.fetchDolls();
  },

  methods: {
    onSubmit() {
      if (this.mode == 'new') {
        this.form.post('/dolls')
          .then(this.fetchDolls());
      } else {
        this.form.patch(`/dolls/${this.form.id}`)
          .then(() => {
            this.fetchDolls();
          });
      }
    },

    edit(doll) {
      this.form.load(doll);
      this.mode = 'edit';
    },

    increase(id) {
      axios.post(`/dolls/${id}/increase`)
        .then(this.fetchDolls());
    },

    decrease(id) {
      axios.post(`/dolls/${id}/decrease`)
        .then(this.fetchDolls());
    },

    fetchDolls() {
      axios.get('/dolls/all')
        .then(response => {
          let dolls = response.data;

          // Recalculate totals
          let newStock = 0;
          let newIdeal = 0;
          let newValue = 0;

          dolls.forEach((doll) => {
            doll.stock = parseInt((doll.stock ? doll.stock : 0), 10);
            doll.ideal = parseInt((doll.ideal ? doll.ideal : 0), 10);
            doll.price = parseInt((doll.price ? doll.price : 0), 10);

            newStock += doll.stock;
            newIdeal += doll.remaining;
            newValue += doll.price;
          })

          this.totals.stock = newStock;
          this.totals.ideal = newIdeal;
          this.totals.value = newValue;

          this.dolls = this.sortBy(this.sort.key, false, dolls);
        })
    },

    sortBy(key, flip = true, dolls = this.dolls) {
      this.sort.key = key;

      let sortedDolls = dolls.sort(function (a, b) {
        let x = a[key];
        let y = b[key];

        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
      })

      if (this.sort.order === 'desc') {
        sortedDolls = sortedDolls.reverse();
      }

      if (flip)
        this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc';

      return sortedDolls;
    }
  }
});
