import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  text-align: center;
  height: 100%;
`;

class ReactCell extends React.Component {
  state = {
    counter: 0
  };

  render() {
    return (
      <StyledDiv
        onClick={() => this.setState({ counter: this.state.counter + 1 })}
      >
        {this.state.counter}
      </StyledDiv>
    );
  }
}

export default ReactCell;
