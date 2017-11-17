import React from 'react'
import Select from 'react-select'
import { connect } from 'react-redux';
import { selectTag } from './actions';
import 'react-select/dist/react-select.css'

class TagsSelect extends React.Component {
  constructor(props) {
    super(props)

    this.state = {
      values: null,
      tags: [
        { value: 3, label: 'Fundraising' },
        { value: 7, label: 'Funding' },
        { value: 14, label: 'VC' }
      ]
    }
  }

  onChange = value => {
    const { dispatch } = this.props

    this.setState({
      values: value
    })

    dispatch(selectTag(value))
  }

  render() {
    return (
      <Select
        name="tags"
        clearable={true}
        multi={true}
        options={this.state.tags}
        value={this.state.values}
        placeholder="Add tags"
        onChange={this.onChange}
      />
    )
  }
}

export default connect()(TagsSelect);
