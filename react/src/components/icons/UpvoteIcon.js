// @flow
import React from "react";
import styled from "styled-components";

const StyledDiv = styled.div`
  display: inline-block;
  margin-right: 3px;
  margin-left: 2px;
`;

const UpVoteIcon = props => (
  <StyledDiv {...props}>
    <svg width="8" height="6" viewBox="0 0 14 8">
      <path
        fillRule="evenodd"
        d="M217.370461,129.289806 L222.16314,133.799897 L222.16314,133.799897 C222.565342,134.178383 222.584567,134.811256 222.20608,135.213458 C222.017102,135.414277 221.753585,135.528147 221.477829,135.528147 L210.521849,135.528147 L210.521849,135.528147 C209.969564,135.528147 209.521849,135.080432 209.521849,134.528147 C209.521849,134.252391 209.635719,133.988875 209.836538,133.799897 L214.629217,129.289806 L214.629217,129.289806 C215.399288,128.565141 216.60039,128.565141 217.370461,129.289806 Z"
        transform="translate(-209 -128)"
      />
    </svg>
  </StyledDiv>
);

export default UpVoteIcon;
