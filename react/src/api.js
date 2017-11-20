// @flow
import fetch from "./utils/fetch";

const API_URL = "http://spreadshare.docker:81";

export const fetchDataApi = method =>
  fetch(`${API_URL}/api/v1/${method}`, {
    method: "GET"
  }).then(response => response.json());
