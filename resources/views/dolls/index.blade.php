@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col col-12">

      <div v-cloak id="dolls-list">

        <div id="accordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <div class="row">
                <div class="col">
                  <h4 class="pull-left mt-2">Dolls</h4>
                </div>
                <div class="col">
                  <button class="btn btn-link pull-right mb-3" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    New Doll
                  </button>
                </div>
              </div>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body">

                <form method="POST" action="" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

                <input type="hidden" name="id" v-model="form.id">

                  <div class="form-row form-group">

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name" name="name" v-model="form.name">
                      <div class="invalid-feedback" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></div>
                    </div>

                  </div>

                  <div class="form-row form-group">

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('stock') }" placeholder="Actual Stock" name="stock" v-model="form.stock">
                      <div class="invalid-feedback" v-if="form.errors.has('stock')" v-text="form.errors.get('stock')"></div>
                    </div>

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('ideal') }" placeholder="Ideal Stock" name="ideal" v-model="form.ideal">
                      <div class="invalid-feedback" v-if="form.errors.has('ideal')" v-text="form.errors.get('ideal')"></div>
                    </div>

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('price') }" placeholder="Price" name="price" v-model="form.price">
                      <div class="invalid-feedback" v-if="form.errors.has('price')" v-text="form.errors.get('price')"></div>
                    </div>

                  </div>

                  <div class="form-row form-group">

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('priority') }" placeholder="Priority" name="priority" v-model="form.priority">
                      <div class="invalid-feedback" v-if="form.errors.has('priority')" v-text="form.errors.get('priority')"></div>
                    </div>

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('rank') }" placeholder="Rank" name="rank" v-model="form.rank">
                      <div class="invalid-feedback" v-if="form.errors.has('rank')" v-text="form.errors.get('rank')"></div>
                    </div>

                    <div class="col">
                      <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('etsy_id') }" placeholder="Etsy ID" name="etsy_id" v-model="form.etsy_id">
                      <div class="invalid-feedback" v-if="form.errors.has('etsy_id')" v-text="form.errors.get('etsy_id')"></div>
                    </div>

                  </div>

                  <div class="form-row form-group">

                    <div class="col">
                      <textarea name="notes" placeholder="Notes" class="form-control" :class="{ 'is-invalid': form.errors.has('notes') }" v-model="form.notes"></textarea>
                      <div class="invalid-feedback" v-if="form.errors.has('notes')" v-text="form.errors.get('notes')"></div>
                    </div>

                  </div>

                  <div class="form-group text-right">
                    <input class="btn btn-primary" type="submit" name="submit" :value="mode == 'edit' ? 'Save' : 'Create'">
                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>

        <div class="row text-center">
          <div class="col">
            <div class="card bg-light">
              <div class="card-body">
                <h1>@{{ daysUntil }}</h1>
                <p>Days Remaining</p>
              </div>
            </div>
          </div>

          {{--<div class="col">--}}
            {{--<div class="card text-white bg-secondary">--}}
              {{--<div class="card-body">--}}
                {{--<h1></h1>--}}
                {{--<p></p>--}}
              {{--</div>--}}
            {{--</div>--}}
          {{--</div>--}}

          <div class="col">
            <div class="card text-white bg-dark">
              <div class="card-body">
                <h1>@{{ totals.ideal }}</h1>
                <p>Stock Remaining <small><em>(@{{ (totals.ideal / (daysUntil / 7)).toFixed(1) }} per week)</em></small></p>
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card text-white bg-info">
              <div class="card-body">
                <h1>@{{ totals.stock }}</h1>
                <p>Stock Available <small><em>($@{{ totals.value }})</em></small></p>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body table-full-width table-responsive">
          <table class="table table-hover">
          <thead>
            <tr>
              {{--<th @click="sortBy('id')" scope="col">#</th>--}}
              <th @click="sortBy('name')" scope="col">Name</th>
              <th @click="sortBy('priority')" class="text-center" scope="col">Priority</th>
              <th @click="sortBy('stock')" class="text-center" scope="col">Actual Stock</th>
              <th @click="sortBy('ideal')" class="text-center" scope="col">Ideal Stock</th>
              <th @click="sortBy('remaining')" class="text-center" scope="col">Remaining</th>
              <th @click="sortBy('price')" class="text-center" scope="col">Price</th>
              <th @click="sortBy('rank')" scope="col">Rank</th>
              <th @click="sortBy('etsy_id')" scope="col">Etsy ID</th>
              <th @click="sortBy('notes')" scope="col">Notes</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="doll of dolls" :class="doll.remaining ? 'table-warning' :' '">
              {{--<td scope="row">@{{ doll.id }}</td>--}}
              <td>@{{ doll.name }}</td>
              <td class="text-center">@{{ doll.priority }}</td>
              <td class="text-center">@{{ doll.stock }}</td>
              <td class="text-center">@{{ doll.ideal }}</td>
              <td class="text-center">@{{ doll.remaining }}</td>
              <td class="text-center">@{{ doll.price }}</td>
              <td>@{{ doll.rank }}</td>
              <td>@{{ doll.etsy_id }}</td>
              <td>@{{ doll.notes }}</td>
              <td class="text-right">
                <div class="btn-group">
                  <a href="#" @click="decrease(doll.id)" class="btn btn-default btn-sm"><i class="nc-icon nc-simple-delete"></i></a>
                  <a href="#" @click="increase(doll.id)" class="btn btn-default btn-sm"><i class="nc-icon nc-simple-add"></i></a>
                </div>
                <a href="#" @click="edit(doll)" class="btn btn-success btn-sm">Edit</a>
              </td>
            </tr>
          </tbody>
        </table>
        </div>

      </div>

    </div>
  </div>
@endsection
