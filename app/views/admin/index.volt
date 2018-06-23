{% extends 'layouts/main.volt' %} {% block title %}SpreadShare - Lists{% endblock %} {% block header %} {% endblock %} {%
block content %}
<div class="re-page">

    <div class="u-flex u-sm-flexCol u-md-flexRow u-flexJustifyBetween u-md-flexAlignItemsEnd lists-page-space">
        <div>
            <h1 class="re-heading">Admin</h1>
            <h2 class="re-subheading re-subheading--button-below">Spreadshare mini administration panel</h2>
        </div>
    </div>
    <div id="app">
        <div class="ui four item menu">
            <a data-tab="tstreams" :class="{ active: tab == 0 ? true : false }" v-on:click="getFeatured('Streams');" class="item">Streams</a>
            <a data-tab="tcurators" :class="{ active: tab == 1 ? true : false }" v-on:click="getFeatured('Curators');" class="item">Curators</a>
            <a data-tab="tusers" :class="{ active: tab == 2 ? true : false }" v-on:click="getFeatured('Users');" class="item">Users</a>
            <a data-tab="ttags" :class="{ active: tab == 3 ? true : false }" v-on:click="getFeatured('Tags');" class="item">Tags</a>
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
                        </td>

                        <td class="right aligned  collapsing">
                            <div class="ui checkbox">
                                <input :id='item.id' v-on:click="setFeatured('Streams', $event)" v-if="item.featured == '1'" type="checkbox" checked name="example">
                                <input :id='item.id' v-on:click="setFeatured('Streams', $event)" v-if="item.featured == '0'" type="checkbox" name="example">
                                <label></label>
                            </div>
                        </td>

                    </tr>

                </tbody>
            </table>
            </div>



            <div class="ui bottom  tab " data-tab="tcurators" :class="{ active: tab == 1 ? true : false }">
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
                                    ${ item.title }
                                    <div class="sub header">
                                        ${ item.tagline }
                                    </div>
                            </td>

                            <td class="right aligned  collapsing">
                                <div class="ui checkbox">
                                    <input :id='item.id' v-on:click="setFeatured('Curators', $event)" v-if="item.featured == '1'" type="checkbox" checked name="example">
                                    <input :id='item.id' v-on:click="setFeatured('Curators', $event)" v-if="!item.featured == '1'" type="checkbox" name="example">
                                    <label></label>
                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
                </div>

                <div class="ui bottom tab " data-tab="tusers" :class="{ active: tab == 2 ? true : false }" :class="{ active: tab == 2 ? true : false }">
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
                                        ${ item.title }
                                        <div class="sub header">
                                            ${ item.tagline }
                                        </div>
                                </td>

                                <td class="right aligned  collapsing">
                                    <div class="ui checkbox">
                                        <input :id='item.id' v-on:click="setFeatured('Users', $event)" v-if="item.featured == '1'" type="checkbox" checked name="example">
                                        <input :id='item.id' v-on:click="setFeatured('Users', $event)" v-if="!item.featured == '1'" type="checkbox" name="example">
                                        <label></label>
                                    </div>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                    </div>

                    <div class="ui bottom  tab " data-tab="ttags" :class="{ active: tab == 3 ? true : false }">
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
                                    </td>

                                    <td class="right aligned  collapsing">
                                        <div class="ui checkbox">
                                            <input :id='item.id' v-on:click="setFeatured('Users', $event)" v-if="item.featured == '1'" type="checkbox" checked name="example">
                                            <input :id='item.id' v-on:click="setFeatured('Users', $event)" v-if="!item.featured == '1'" type="checkbox" name="example">
                                            <label></label>
                                        </div>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        </div>


                    </div>
                </div>


                {% endblock %} {% block scripts %}

                <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>



                <script type="text/javascript">
                    $(document).ready(function () {

                        var app = new Vue({
                            delimiters: ['${', '}'],
                            el: '#app',
                            created: function () {
                                this.getFeatured("Streams")
                            },
                            data() {
                                return {
                                    tab: 0,
                                    data: {
                                        Streams: [],
                                        Curators: [],
                                        Users: [],
                                        Tags: [],
                                    }

                                }
                            },
                            methods: {
                                setFeatured: function (type, event) {
                                    console.log(event.target.checked)
                                    console.log(event.target.id)
                                    axios({
                                        method: event.target.checked ? 'post' : "delete",
                                        url: `api/v2/Featured${type}/${event.target.id}`,
                                        data: {
                                            type,
                                            id: event.target.id,
                                            checked: event.target.checked
                                        }
                                    });
                                },
                                getFeatured: function (type) {
                                    if (type == "Streams") this.tab = 0
                                    if (type == "Curators") this.tab = 1
                                    if (type == "Users") this.tab = 2
                                    if (type == "Tags") this.tab = 3
                                    var self = this
                                    axios({
                                        method: "get",
                                        url: `api/v2/Featured${type}`,
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