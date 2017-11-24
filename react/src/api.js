// @flow
const API_URL = "http://spreadshare.docker:81";

export const fetchDataApi = (method: string) =>
  fetch(`${API_URL}/api/v1/${method}`, {
    method: "GET"
  }).then(response => response.json());

export const saveDataApi = (method: string, body: Object) =>
  fetch(`${API_URL}/api/v1/${method}`, {
    method: "POST",
    body: JSON.stringify(body)
  }).then(response => response.json());
