// @flow
// this is needed to make cookies send properly which doesn't work with
// normal fetch
/**
 * Fetch wrapper
 *
 * @copyright 2016 Aspirantic.com
 * @package React/Utils
 * @version 1.0
 */

import parentFetch from "isomorphic-fetch";

export default function fetch(url, options = { method: "GET" }) {
  options.cache = options.cache || "default";
  options.credentials = "include";

  // No-cors produces an "unexpected end of input" in json requests
  // Currently don't have a clue why :)
  // But cors is working fine..
  options.mode = "cors";

  try {
    return parentFetch(url, options);
  } catch (e) {
    console.error(e);
  }
}

// noinspection JSUnusedGlobalSymbols
/**
 * Retrieve json object from response
 * @param response
 * @returns {*}
 */
export function jsonResponse(response) {
  return response.json();
}

// noinspection JSUnusedGlobalSymbols
/**
 * Retrieve text object from response
 * @param response
 * @returns {*}
 */
export function textResponse(response) {
  return response.text();
}
