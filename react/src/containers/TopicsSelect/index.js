// @flow
import React, { Component } from "react";
import { bindActionCreators } from "redux";
import { connect } from "react-redux";
import Select from "react-select";
import "react-select/dist/react-select.css";

import { fetchTopics } from "./actions";

class TopicsSelect extends Component {
  static defaultProps = {
    values: [],
    name: "topics[]",
    placeholder: <span>Select topics</span>
  };

  constructor(props) {
    super(props);

    let values = [];
    if (props.values && typeof props.values === 'string') {
      values = JSON.parse(props.values);
      if (!values) {
        values = [];
      }
    }

    this.state = {
      values
    };
  }

  componentWillMount() {
    this.props.fetchTopics();
  }

  selectChanged = values => {
    if (values.length <= 2) {
      this.setState({
        values
      });
    }
  };

  render() {
    return (
      <div>
        <Select
          name={this.props.name}
          multi
          options={this.props.topics}
          value={this.state.values}
          placeholder={
            this.props.loading ? "Loading.." : this.props.placeholder
          }
          onChange={this.selectChanged}
        />
      </div>
    );
  }
}

const mapStateToProps = state => ({
  topics: state.topics.all,
  loading: state.topics.isFetching
});

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchTopics
    },
    dispatch
  );

export default connect(mapStateToProps, mapDispatchToProps)(TopicsSelect);
