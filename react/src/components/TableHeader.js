// @flow
import * as React from 'react';
import styled from 'styled-components';

const StyledDiv = styled.div`
  display: flex;
  background: #ffffff;
  padding: 20px 16px;
`;

type Props = {
  children?: React.Node,
};

const TableHeader = (props: Props) =>
  <StyledDiv>
    {props.children}
  </StyledDiv>;

export default TableHeader;
