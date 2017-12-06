// @flow
import * as React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  
`;

type Props = {
  children?: React.Node
};

const TableHeader = (props: Props) =>
  <StyledDiv className="table-header">
    {props.children}
  </StyledDiv>;

export default TableHeader;
