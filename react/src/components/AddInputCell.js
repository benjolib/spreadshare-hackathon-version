// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
`;

type Props = {
  colIndex: number,
  setupDataGetter: (dataGetter: Function) => void,
  value: string
};

type State = {
  value: string
};

class AddInputCell extends React.Component<Props> {
  props: Props;
  state: State;

  state = {
    value: ""
  };

  componentDidMount() {
    console.log(this.props.value);
    this.props.setupDataGetter(this.props.colIndex, () => {
      const val = this.state.value;
      this.setState({ value: "" });
      return val;
    });
  }

  onChange = e =>
    this.setState({
      value: e.target.value
    });

  render() {
    return (
      <StyledDiv>
        <input type="text" onChange={this.onChange} value={this.state.value} />
        {/* <input
          type="text"
          onChange={e =>
            this.props.updateAddValues(this.props.colIndex, e.target.value)}
          value={this.props.value}
        /> */}
      </StyledDiv>
    );
  }
}

export default AddInputCell;
