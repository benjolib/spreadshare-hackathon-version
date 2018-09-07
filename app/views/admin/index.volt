{% extends 'layouts/main.volt' %}

{% block title %}SpreadShare - Admin{% endblock %}
{% block header %}{% endblock %}

{% block content %}
    <div class="re-page">

        <div class="u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween u-md-flexAlignItemsEnd lists-page-space">
            <div>
                <h1 class="re-heading">Admin</h1>
                <h2 class="re-subheading re-subheading--button-below">Spreadshare mini administration panel</h2>
            </div>
        </div>

        <div id="app">

            <div class="ui five item menu">
                <a data-tab="tstreams"  :class="{ active: tab == 0 ? true : false }" v-on:click="getFeatured('Streams');"   class="item">Streams</a>
                <a data-tab="tcurators" :class="{ active: tab == 1 ? true : false }" v-on:click="getFeatured('Curators');"  class="item">Curators</a>
                <a data-tab="tusers"    :class="{ active: tab == 2 ? true : false }" v-on:click="getFeatured('Users');"     class="item">Users</a>
                <a data-tab="ttags"     :class="{ active: tab == 3 ? true : false }" v-on:click="getFeatured('Tags');"      class="item">Tags</a>
                <a data-tab="tbundles"  :class="{ active: tab == 4 ? true : false }" v-on:click="getFeatured('Bundles');"   class="item">Bundles</a>
            </div>


            <div class="ui bottom tab" data-tab="tstreams" :class="{ active: tab == 0 ? true : false }">
                <table id="admintable" class="ui striped table display" style="display: table">
                    <thead>
                    <tr>
                        <th>STREAM</th>
                        <th class="right aligned collapsing">FEATURE</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="item of data.Streams">
                        <td class="collapsing">
                            <div class="content">
                                ${ item.title }
                                <div class="sub header">
                                    ${ item.tagline }
                                </div>
                            </div>
                        </td>

                        <td class="right aligned  collapsing">
                            <div class="ui checkbox">
                                <input :id='item.id' v-on:click="setFeatured('Streams', $event)" v-if="item.featured == true" type="checkbox" checked name="example">
                                <input :id='item.id' v-on:click="setFeatured('Streams', $event)" v-if="!item.featured == true" type="checkbox" name="example">
                                <label></label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="ui bottom tab" data-tab="tcurators" :class="{ active: tab == 1 ? true : false }">
                <table id="admintable" class="ui striped table display" style="display: table">
                    <thead>
                    <tr>
                        <th>CURATORS</th>
                        <th class="right aligned collapsing">FEATURE</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="item of data.Curators">
                        <td class="collapsing">
                            <div class="content">
                                ${ item.name }
                                <div class="sub header">
                                    ${ item.tagline }
                                </div>
                            </div>
                        </td>

                        <td class="right aligned  collapsing">
                            <div class="ui checkbox">
                                <input :id='item.id' v-on:click="setFeatured('Curators', $event)" v-if="item.featured == true" type="checkbox" checked name="example">
                                <input :id='item.id' v-on:click="setFeatured('Curators', $event)" v-if="!item.featured == true" type="checkbox" name="example">
                                <label></label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="ui bottom tab" data-tab="tusers" :class="{ active: tab == 2 ? true : false }">
                <table id="admintable" class="ui striped table display" style="display: table">
                    <thead>
                    <tr>
                        <th>USERS</th>
                        <th class="right aligned collapsing">CURATOR</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="item of data.Users">
                        <td class="collapsing">
                            <div class="content">
                                ${ item.name }
                                <div class="sub header">
                                    ${ item.tagline }
                                </div>
                            </div>
                        </td>

                        <td class="right aligned  collapsing">
                            <div class="ui checkbox">
                                <input :id='item.id' v-on:click="setFeatured('Users', $event)" v-if="item.curator == true" type="checkbox" checked name="example">
                                <input :id='item.id' v-on:click="setFeatured('Users', $event)" v-if="!item.curator == true" type="checkbox" name="example">
                                <label></label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="ui bottom tab" data-tab="ttags" :class="{ active: tab == 3 ? true : false }">
                <table id="admintable" class="ui striped table display" style="display: table">
                    <thead>
                    <tr>
                        <th>TAGS</th>
                        <th class="right aligned collapsing">FEATURED</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="item of data.Tags">
                        <td class="collapsing">
                            <div class="content">
                                ${ item.title }
                                <div class="sub header">
                                    ${ item.tagline }
                                </div>
                            </div>
                        </td>

                        <td class="right aligned  collapsing">
                            <div class="ui checkbox">
                                <input :id='item.id' v-on:click="setFeatured('Tags', $event)" v-if="item.featured == '1'" type="checkbox" checked name="example">
                                <input :id='item.id' v-on:click="setFeatured('Tags', $event)" v-if="item.featured == '0'" type="checkbox" name="example">
                                <label></label>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="ui bottom tab" data-tab="tbundles" :class="{ active: tab == 4 ? true : false }">
                <table id="admintable" class="ui striped table display" style="display: table">
                    <thead>
                    <tr>
                        <th>BUNDLES</th>
                        <th class="right aligned collapsing">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td class="collapsing">
                            <div>
                                <div>
                                    <label class="typo__label">Title</label>
                                </div>
                                <div class="ui input">
                                    <input v-model="newBundleTitle" placeholder="New Bundle Title" type="text">
                                </div>
                                <div>
                                <label class="typo__label">Tags</label>
                                <multiselect
                                        v-model="newBundleTags"
                                        tag-placeholder="Add this as new tag"
                                        placeholder="Search or add a tag"
                                        label="name"
                                        track-by="code"
                                        :options="newBundleTagsOptions"
                                        :multiple="true"
                                        :taggable="false"
                                ></multiselect>
                                </div>
                            </div>
                        </td>
                        <td class="right aligned collapsing">
                            <button v-on:click="createNewBundle" class="positive ui button">Create</button>
                        </td>
                    </tr>
                    <tr v-for="item of data.Bundles">
                        <td class="collapsing">
                            <div class="content">
                                <!-- ${ item.id } -->
                                ${ item.title }
                                <!-- ${ item.image } -->
                                <br />
                                <div class="ui horizontal bulleted list">
                                    <div class="item" v-for="tag of item.tags">
                                        <div class="content">
                                            <a class="item" :href="'/tag/' + tag.id"><!-- ${ tag.id } -->${ tag.title }</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>

                        <td class="right aligned collapsing">
                            <button v-on:click="deleteBundle(item.id)" class="negative ui button">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </div> <!-- app -->
    </div> <!-- re-page -->

{% endblock %}

{% block scripts %}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>
    <script src="https://unpkg.com/vue-multiselect@2.1.0"></script>

    <script type="text/javascript">
        Vue.component('multiselect', window.VueMultiselect.default);

        Vue.component("confirmation-modal", {
            template: "#modal",
            props: ["open", "questionText", "cancelText", "confirmText"],
            methods: {
                onConfirm() {
                    this.$emit("confirm");
                },
                onCancel() {
                    this.$emit("cancel");
                }
            }
        });

        $(document).ready(function () {
//            $('.ui.dropdown.tags').dropdown({
//                saveRemoteData : true,
//                allowAdditions: false,
//                apiSettings: {
//                    // this url parses query server side and returns filtered results
//                    url: '/api/v2/tags/?q={query}'
//                },
//                label: {
//                    transition : 'horizontal flip',
//                    duration   : 200,
//                    variation  : false,
//                },
//            });

            var app = new Vue({
                delimiters: ['${', '}'],
                el: '#app',
                created: function () {
                    this.getFeatured("Streams");
                    this.populateBundleTagsOptions();
                },

                data: {
                    newBundleTitle: '',
                    newBundleTags: [],
                    newBundleTagsOptions: [
                        // { name: 'Vue.js', code: 'vu' },
                    ],

                    tab: 0,
                    data: {
                        Streams: [],
                        Curators: [],
                        Users: [],
                        Tags: [],
                        Bundles: [],
                    }
                },

                methods: {
                    createNewBundle: function (event) {
                        var newBundleTags = [];
                        for (i = 0; i < this.newBundleTags.length; i++) {
                            newBundleTags.push(this.newBundleTags[i].code);
                        }
                        var path = `api/v3/bundles`;
                        var self = this;
                        axios({
                            method: "post",
                            url: path,
                            data: {
                                title: this.newBundleTitle,
                                image: '',
                                tags: newBundleTags
                            }
                        }).then(function (response) {
                            self.getFeatured("Bundles");
                            self.newBundleTitle = '';
                            self.newBundleTags = [];
                        });
                    },

                    deleteBundle: function (bundleId) {
                        var path = `api/v3/bundles/${bundleId}`;
                        var self = this;
                        axios({
                            method: 'delete',
                            url: path,
                        }).then(function (response) {
                            self.getFeatured("Bundles");
                        });
                    },

                    populateBundleTagsOptions: function () {
                        var path = `api/v2/FeaturedTags`;
                        var self = this;
                        axios({
                            method: "get",
                            url: path,
                        }).then(function (response) {
                            console.log(response.data);
                            // console.log(response.status);
                            // console.log(response.statusText);
                            // console.log(response.headers);
                            // console.log(response.config);
                            //console.log(response.data.results);
                            for (i = 0; i < response.data.results.length; i++) {
                                //console.log(response.data.results[index]);
                                const tag = {
                                    name: response.data.results[i].title,
                                    code: response.data.results[i].id
                                };
                                self.newBundleTagsOptions.push(tag);
                            }
                        });
                    },

                    setFeatured: function (type, event) {
                        console.log(event.target.checked);
                        console.log(event.target.id);
                        var path = `api/v2/Featured${type}/${event.target.id}`;
                        if (type == 'Users') {
                            path = `api/v2/Curators/${event.target.id}`;
                        }
                        axios({
                            method: event.target.checked ? 'post' : 'delete',
                            url: path,
                            data: {
                                type,
                                id: event.target.id,
                                checked: event.target.checked
                            }
                        });
                    },
                    getFeatured: function (type) {
                        var path = `api/v2/Featured${type}`;
                        switch (type) {
                            case 'Streams':
                                this.tab = 0;
                                break;

                            case 'Curators':
                                this.tab = 1;
                                break;

                            case 'Users':
                                this.tab = 2;
                                path = `api/v2/${type}`;
                                break;

                            case 'Tags':
                                this.tab = 3
                                break;

                            case 'Bundles':
                                this.tab = 4
                                var path = `api/v3/Bundles`;
                                break;

                            default:
                                return;
                        }

                        var self = this;
                        axios({
                            method: "get",
                            url: path,
                        }).then(function (response) {
                            console.log(response.data);
                            // console.log(response.status);
                            // console.log(response.statusText);
                            // console.log(response.headers);
                            // console.log(response.config);
                            self.data[type] = response.data.results
                        });
                    }
                }

            })
        });
    </script>
{% endblock %}
