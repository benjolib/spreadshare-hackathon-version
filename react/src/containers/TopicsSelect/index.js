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

  selectChanged = (value) => {
    if (value.length <= 2) {
      this.setState({
        value
      });
    }
  };

  render() {
    return <div>
      <Select
        name="topic"
        multi={true}
        options={this.props.topics}
        value={this.state.value}
        placeholder={this.props.loading ? 'Loading..' : 'Choose topics'}
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
