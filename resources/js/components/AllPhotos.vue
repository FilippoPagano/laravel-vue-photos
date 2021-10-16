<template>
    <div v-if="photos && userName && likes">
        <h2>All photos</h2>
        <p class="mt-3" align="center">Current Page: {{ currentPage }}</p>
        <b-pagination
            v-model="currentPage"
            :total-rows="photos.length"
            :per-page="itemsPerPage"
            aria-controls="photosCardGroup"
            align="center"
        ></b-pagination>
        <b-card-group id="photosCardGroup" deck>
            <b-card
                v-for="photo in photos.slice(
                    (currentPage - 1) * itemsPerPage,
                    currentPage * itemsPerPage
                )"
                :key="photo.id"
                :img-src="photo.url"
                no-body
                img-alt="Card image"
                img-top
            >
                <b-card-text style="height: -webkit-fill-available">
                    ID: {{ photo.id }} <br />
                    {{ photo.title }}
                </b-card-text>
                <b-card-footer>
                    <b-button
                        class="float-right"
                        v-if="
                            !likes.filter(l => {
                                return l.photo == photo.id && l.user == userName
                            }).length
                        "
                        v-on:click="like(photo.id, $event.target)"
                        ><font-awesome-icon
                            :icon="['fas', 'heart']"
                        />&nbsp;Favourite</b-button
                    >
                    <b-button
                        class="float-right"
                        v-if="
                            likes.filter(l => {
                                return l.photo == photo.id && l.user == userName
                            }).length
                        "
                        v-on:click="unlike(photo.id, $event.target)"
                        ><font-awesome-icon
                            :icon="['fas', 'heart-broken']"
                        />&nbsp;Unfavourite</b-button
                    >
                </b-card-footer>
            </b-card>
        </b-card-group>
    </div>
</template>

<script>
export default {
    mounted () {
        var that = this
        this.$root.$on('changeUsername', function () {
            that.userName = Vue.localStorage.get('userName')
        })
        this.$http.get(`/api/likes`).then(function (response) {
            that.likes = response.data
        })
        this.$http
            .get('http://jsonplaceholder.typicode.com/photos')
            .then(function (response) {
                that.photos = response.data
            })
    },
    data () {
        return {
            photos: [],
            likes: [],
            currentPage: 1,
            itemsPerPage: 3,
            userName: Vue.localStorage.get('userName')
        }
    },
    methods: {
        async like (id, target) {
            const response = await this.$http.post(
                `/api/like/${localStorage.userName}/${id}`
            )
            this.likes.push({ photo: id, user: this.userName })
        },
        async unlike (id, target) {
            const response = await this.$http.post(
                `/api/unlike/${localStorage.userName}/${id}`
            )
            this.likes.splice(
                this.likes
                    .map(l => {
                        return l.photo == id && l.user == this.userName
                    })
                    .indexOf(true),
                1
            )
        }
    }
}
</script>
