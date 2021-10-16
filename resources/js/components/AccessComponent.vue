<template>
  <div class="container">
    <div v-if="userName">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Hello, {{ userName }}!</div>

            <div class="card-body">
              You are logged in.
              <b-button variant="outline-primary" @click="logout">Logout</b-button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="!userName">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Hello, guest user!</div>

            <div class="card-body">
              You are not logged in.
              <b-input-group prepend="Username" class="mt-3">
                <b-form-input id="loginInput"></b-form-input>
                <b-input-group-append>
                  <b-button variant="outline-success" @click="login">Login</b-button>
                </b-input-group-append>
              </b-input-group>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("access component mounted");
  },
  data() {
    return {
      userName: Vue.localStorage.get("userName"),
    };
  },
  methods: {
    login() {
      Vue.localStorage.set("userName", document.getElementById("loginInput").value);
      this.userName = document.getElementById("loginInput").value;
      this.$root.$emit("changeUsername");
    },
    logout() {
      Vue.localStorage.set("userName", "");
      this.userName = "";
      this.$root.$emit("changeUsername");
    },
  },
};
</script>
