<template>
  <div v-if="!userName && biggestFans && !(new Date().getDay() == 6 || new Date().getDay() == 0)">
    <h2>Top followers</h2>
    <ul id="example-1">
      <li v-for="fan in biggestFans" :key="fan">
        {{ fan }}
      </li>
    </ul>
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
        that.updateRank();
      });
    });
    this.$http.get(`/api/likes`).then(function (response) {
      that.likes = response.data;
      that.updateRank()
    });
  },
  data() {
    return {
      biggestFans: [],
      likes: [],
      userName: Vue.localStorage.get("userName"),
    };
  },
  methods: {
    updateRank() {
      var reduced = this.likes.reduce(function (acc, curr) {
        return acc[curr.user] ? ++acc[curr.user] : acc[curr.user] = 1, acc
      }, {});
      this.biggestFans = Object.entries(reduced).map(([key, value]) => ({key,value})).sort((a,b)=>{return b.value-a.value}).map((el)=>{return el.key});
    }
    
  }


};
</script>
