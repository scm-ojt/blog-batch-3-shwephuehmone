<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-info">Register</h3>
                        <form @submit.prevent= "submit()">
                            <div class="form-group">
                            <input type="text" v-model= "name" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                            <input type="text" v-model= "email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group mt-3">
                            <input type="password" v-model= "password" class="form-control" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 btn-block">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </template>
  <script>
import { METHODS } from 'http';

  export default {
    name: "register",
    data(){
        return {
            name: '',
            email: '',
            password: ''
        }
    },
  }
  </script>