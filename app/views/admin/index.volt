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
            <a data-tab="streams" v-on:click="getFeatured('streams')" class=" item active ">Streams</a>
            <a data-tab="curators" class="item">Curators</a>
            <a data-tab="users" class="item">Users</a>
            <a data-tab="tags" class="item">Tags</a>
        </div>

        <div class="ui bottom  tab active" data-tab="streams">

            <table id="admintable" class="ui striped table display" style="display: table">
                <thead>
                    <tr>
                        <th>STREAM</th>
                        <th class="right aligned collapsing">FEATURE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item of data.streams">

                        <td class="collapsing">
                            <div class="content">
                                ${ item.title }
                                <div class="sub header">
                                    ${ item.tagline }
                                </div>
                        </td>

                        <td class="right aligned  collapsing">
                            <div class="ui checkbox">
                                <input :id='item.id' v-on:click="setFeatured('stream', $event)" v-if="item.featured" type="checkbox" checked name="example">
                                <input :id='item.id' v-on:click="setFeatured('stream', $event)" v-if="!item.featured" type="checkbox" name="example">
                                <label></label>
                            </div>
                        </td>

                    </tr>

                </tbody>
            </table>
            </div>

        </div>

        <div class="ui bottom  segment tab " data-tab="curators">
            Second
        </div>

        <div class="ui bottom segment  tab " data-tab="users">
            Third
        </div>

        <div class="ui bottom segment  tab " data-tab="tags">
            Fourth
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
                data() {
                    return {
                        message: "With vue",
                        data: {
                            streams: [{
                                    id: 1,
                                    title: "Stream1",
                                    tagline: "tagline1",
                                    featured: true,
                                },
                                {
                                    id: 6,
                                    title: "Stream2",
                                    tagline: "tagline2",
                                    featured: false,
                                }
                            ],
                            curators: [],
                            users: [],
                            tags: [],
                        }

                    }
                },
                methods: {
                    setFeatured: function (type, event) {
                        console.log(event.target.checked)
                        console.log(event.target.id)
                        // axios({
                        // method: event.target.checked ? 'post': "delete",
                        // url: `/v2/featured/${type}/${event.target.id}`,
                        // data: {
                        //     type,
                        //     id,
                        //     checked
                        // }
                        // });
                    },
                    getFeatured: function (type) {
                        console.log(event.target.checked)
                        console.log(event.target.id)
                        data = [{
                                id: 1,
                                title: "Streaasdasdm1",
                                tagline: "taglasdsadadine1",
                                featured: true,
                            },
                            {
                                id: 6,
                                title: "Streasdsadam2",
                                tagline: "tagliasdsadne2",
                                featured: false,
                            }
                        ]
                        // this.data[type] = data
                        // axios({
                        // method: "get",
                        // url: `/v2/featured/${type}`,
                        // }).then(function(response) {
                        //     console.log(response.data);
                        //     console.log(response.status);
                        //     console.log(response.statusText);
                        //     console.log(response.headers);
                        //     console.log(response.config);
                        //      this.data[type] = response.data
                        //   });
                    }
                }

            })
        });
    </script>
    {% endblock %}