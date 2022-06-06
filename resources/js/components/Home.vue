<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                showUrl:false,
                warning: false,
                shortUrl: '',
                warningMsg: '',
                longUrl: '',
            }
        },
        methods: {
            encodeUrl() {
                this.showUrl = false;
                this.warning = false;
                this.shortUrl = '';
                this.warningMsg = '';

                if (this.longUrl === '') {
                    this.warningMsg = 'Please input an URL first.';
                    this.warning = true;
                } else {
                    axios.post('/api/encode/url', { url: this.longUrl})
                        .then(res => {
                            if (res.data.success) {
                                this.shortUrl = res.data.shortened_url;
                                this.showUrl = true;
                            }
                        })
                        .catch(e => {
                            this.warningMsg = e.response.data.message;
                            this.warning = true;
                        });
                }
            }
        }
    }
</script>

<template>
    <header class="bg-secondary bg-gradient">
        <div class="container text-white pt-5 pb-5">
            <h1 class="text-lg pt-5">Url Shortener</h1>
            <p>Shorten long url and share with ease.</p>
        </div>
    </header>

    <section id="url-submission">
        <div class="container pt-2">
            <div class="row justify-content-center">
                <div class="input-group mb-3">
                    <input type="text"
                           class="form-control"
                           placeholder="Long URL to shorten"
                           v-model="longUrl"
                    >
                    <button
                        class="btn btn-primary btn-outline-primary text-white"
                        type="button"
                        id="button-addon2"
                        @click="encodeUrl"
                    >Go</button>
                </div>
            </div>

            <div class="alert alert-success" role="alert" v-show="showUrl">
                Your shortened url is: {{ shortUrl }}
            </div>

            <div class="alert alert-danger" role="alert" v-show="warning">
                {{ warningMsg }}
            </div>
        </div>
    </section>
</template>
