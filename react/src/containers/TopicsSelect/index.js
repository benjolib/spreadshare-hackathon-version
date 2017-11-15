import React from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import Select from 'react-select';
import 'react-select/dist/react-select.css';

import { fetchTopics } from './actions';

class TopicsSelect extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      value: props.topics || null,
    };
  }

  componentWillMount() {
    this.props.fetchTopics();
  }

  selectChanged = (val) => {
    this.setState({
      value: val.value,
    });
  };

  render() {
    return <div>
      <Select
        name="location"
        options={this.props.topics}
        value={this.state.value}
        placeholder={this.props.loading ? 'Loading..' : 'Select Location'}
        onChange={this.selectChanged}
      />
    </div>;
  }
}

const mapStateToProps = state => ({
  topics: state.topics.all,
  loading: state.topics.isFetching,
});

const mapDispatchToProps = dispatch => bindActionCreators({
  fetchTopics,
}, dispatch);

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(TopicsSelect);
