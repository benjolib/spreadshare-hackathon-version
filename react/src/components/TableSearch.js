// @flow
import React from 'react';
import styled from 'styled-components';

const StyledDiv = styled.div`
  margin: 0 4px;
  margin-left: auto;
  height: 40px;
  background: #f2f2f8;
  width: 225px;
  display: flex;
  border-radius: 3px;
  & > button {
    border: 0;
    padding: 0;
    border-radius: 3px;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    background: #f2f2f8;
  }
  & > input {
    border: 0;
    padding: 0;
    padding-top: 4px;
    flex-grow: 1;
    border-radius: 3px;
    height: 40px;
    font-size: 16px;
    width: 100%;
    outline: none;
  }
`;

type Props = {
  onChange: (e: SyntheticInputEvent) => void,
};

const TableSearch = (props: Props) =>
  <StyledDiv>
    <button>
      <img src="/assets/icons/search.svg" alt="" />
    </button>
    <input type="text" placeholder="Search Table" onChange={props.onChange} />
  </StyledDiv>;

export default TableSearch;
