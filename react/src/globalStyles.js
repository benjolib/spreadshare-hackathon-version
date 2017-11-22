// @flow
/* eslint-disable no-unused-expressions */
import { injectGlobal } from "styled-components";

// declare only some simple css which is hard to declare at component level
injectGlobal`
  html {
    font-size: 100%;
  }

  body {
    margin: 0;
    padding: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial,
      sans-serif;
    font-size: 1rem;
    line-height: 1.5;
    background: #f2f2f8;
  }

  button:disabled {
    opacity: 0.5;
  }
`;
