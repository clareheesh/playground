webpackJsonp([1],{

/***/ "./resources/assets/js/app.js":
/***/ (function(module, exports, __webpack_require__) {


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = __webpack_require__("./node_modules/vue/dist/vue.common.js");

__webpack_require__("./resources/assets/js/bootstrap.js");
__webpack_require__("./resources/assets/js/form.js");

/***/ }),

/***/ "./resources/assets/js/bootstrap.js":
/***/ (function(module, exports, __webpack_require__) {


window._ = __webpack_require__("./node_modules/lodash/lodash.js");

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = __webpack_require__("./node_modules/jquery/dist/jquery.js");

  __webpack_require__("./node_modules/bootstrap-sass/assets/javascripts/bootstrap.js");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__("./node_modules/axios/index.js");

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

/***/ }),

/***/ "./resources/assets/js/form.js":
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var Errors = function () {
  /**
   * Create a new Errors instance.
   */
  function Errors() {
    _classCallCheck(this, Errors);

    this.errors = {};
  }

  /**
   * Determine if an errors exists for the given field.
   *
   * @param {string} field
   */


  _createClass(Errors, [{
    key: 'has',
    value: function has(field) {
      return this.errors.hasOwnProperty(field);
    }

    /**
     * Determine if we have any errors.
     */

  }, {
    key: 'any',
    value: function any() {
      return Object.keys(this.errors).length > 0;
    }

    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */

  }, {
    key: 'get',
    value: function get(field) {
      if (this.errors[field]) {
        return this.errors[field][0];
      }
    }

    /**
     * Record the new errors.
     *
     * @param {object} errors
     */

  }, {
    key: 'record',
    value: function record(errors) {
      this.errors = errors;
    }

    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */

  }, {
    key: 'clear',
    value: function clear(field) {
      if (field) {
        delete this.errors[field];

        return;
      }

      this.errors = {};
    }
  }]);

  return Errors;
}();

var Form = function () {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  function Form(data) {
    _classCallCheck(this, Form);

    this.originalData = data;

    for (var field in data) {
      this[field] = data[field];
    }

    this.errors = new Errors();
  }

  /**
   * Fetch all relevant data for the form.
   */


  _createClass(Form, [{
    key: 'data',
    value: function data() {
      var data = {};

      for (var property in this.originalData) {
        data[property] = this[property];
      }

      return data;
    }

    /**
     * Update the data in the form
     */

  }, {
    key: 'load',
    value: function load(data) {
      for (var property in data) {
        this[property] = data[property];
      }
    }

    /**
     * Reset the form fields.
     */

  }, {
    key: 'reset',
    value: function reset() {
      for (var field in this.originalData) {
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

  }, {
    key: 'post',
    value: function post(url) {
      return this.submit('post', url);
    }

    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */

  }, {
    key: 'put',
    value: function put(url) {
      return this.submit('put', url);
    }

    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */

  }, {
    key: 'patch',
    value: function patch(url) {
      return this.submit('patch', url);
    }

    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */

  }, {
    key: 'delete',
    value: function _delete(url) {
      return this.submit('delete', url);
    }

    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */

  }, {
    key: 'submit',
    value: function submit(requestType, url) {
      var _this = this;

      return new Promise(function (resolve, reject) {
        axios[requestType](url, _this.data()).then(function (response) {
          _this.onSuccess(response.data);

          resolve(response.data);
        }).catch(function (error) {
          _this.onFail(error.response.data);

          reject(error.response.data);
        });
      });
    }

    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */

  }, {
    key: 'onSuccess',
    value: function onSuccess() {
      this.reset();
    }

    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */

  }, {
    key: 'onFail',
    value: function onFail(errors) {
      this.errors.record(errors);
    }
  }]);

  return Form;
}();

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
      key: 'remaining',
      order: 'desc'
    },
    mode: 'new',
    totals: {
      stock: 0,
      ideal: 0,
      value: 0
    }
  },

  computed: {
    daysUntil: function daysUntil() {
      var today = new Date();
      var supanova = new Date(2018, 11, 9);

      return Math.round(Math.abs((today.getTime() - supanova.getTime()) / (24 * 60 * 60 * 1000)));
    }
  },

  created: function created() {
    this.fetchDolls();
  },


  methods: {
    onSubmit: function onSubmit() {
      var _this2 = this;

      if (this.mode == 'new') {
        this.form.post('/dolls').then(this.fetchDolls());
      } else {
        this.form.patch('/dolls/' + this.form.id).then(function () {
          _this2.fetchDolls();
        });
      }
    },
    edit: function edit(doll) {
      this.form.load(doll);
      this.mode = 'edit';
    },
    increase: function increase(id) {
      axios.post('/dolls/' + id + '/increase').then(this.fetchDolls());
    },
    decrease: function decrease(id) {
      axios.post('/dolls/' + id + '/decrease').then(this.fetchDolls());
    },
    fetchDolls: function fetchDolls() {
      var _this3 = this;

      axios.get('/dolls/all').then(function (response) {
        _this3.dolls = response.data;

        // Recalculate totals
        var newStock = 0;
        var newIdeal = 0;
        var newValue = 0;

        _this3.dolls.forEach(function (doll) {
          doll.stock = parseInt(doll.stock ? doll.stock : 0, 10);
          doll.ideal = parseInt(doll.ideal ? doll.ideal : 0, 10);
          doll.price = parseInt(doll.price ? doll.price : 0, 10);

          newStock += doll.stock;
          newIdeal += doll.remaining;
          newValue += doll.price;
        });

        _this3.totals.stock = newStock;
        _this3.totals.ideal = newIdeal;
        _this3.totals.value = newValue;
      });

      this.sortBy(this.sort.key, false);
    },
    sortBy: function sortBy(key) {
      var flip = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

      this.sort.key = key;

      this.dolls = this.dolls.sort(function (a, b) {
        var x = a[key];
        var y = b[key];

        return x < y ? -1 : x > y ? 1 : 0;
      });

      if (this.sort.order === 'desc') {
        this.dolls = this.dolls.reverse();
      }

      if (flip) this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc';
    }
  }
});

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/assets/sass/auth.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/assets/sass/light-bootstrap-dashboard.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/app.js");
__webpack_require__("./resources/assets/sass/app.scss");
__webpack_require__("./resources/assets/sass/auth.scss");
module.exports = __webpack_require__("./resources/assets/sass/light-bootstrap-dashboard.scss");


/***/ })

},[0]);