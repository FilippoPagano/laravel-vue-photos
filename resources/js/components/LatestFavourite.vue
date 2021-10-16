<template>
  <div v-if="photos && !userName && likes && (new Date().getDay() == 6 || new Date().getDay() == 0)">
    <h2>Latest likes</h2>
    <p class="mt-3" align="center">Current Page: {{ currentPage }}</p>
    <b-pagination
      v-model="currentPage"
      :total-rows="likes.length"
      :per-page="itemsPerPage"
      aria-controls="latestLikes"
      align="center"
    ></b-pagination>
    <b-card-group id="latestLikes" deck>
      <b-card
        v-for="like in likes.slice(
          (currentPage - 1) * itemsPerPage,
          currentPage * itemsPerPage
        )"
        :key="like.id"
        :img-src="photos.find((p)=>{return p.id==like.photo}).url"
        no-body
        img-alt="Card image"
        img-top
      >
        <b-card-text style="height: -webkit-fill-available;">
          ID: {{ like.photo }} <br>
          {{ photos.find((p)=>{return p.id==like.photo}).title }}
        </b-card-text>
      </b-card>
    </b-card-group>
  </div>
</template>

<script>
export default {
  mounted() {
    var that = this;
    this.$root.$on("changeUsername", function () {
      that.userName = Vue.localStorage.get("userName");
      this.$http.get(`/api/likes`).then(function (response) {
        that.likes = response.data;
      });
    });
    this.$http.get(`/api/likes`).then(function (response) {
      that.likes = response.data;
    });
    this.$http
      .get("http://jsonplaceholder.typicode.com/photos")
      .then(function (response) {
        that.photos = response.data;
      });
  },
  data() {
    return {
      photos: [],
      likes: [],
      currentPage: 1,
      itemsPerPage: 3,
      userName: Vue.localStorage.get("userName"),
    };
  },
};
</script>
