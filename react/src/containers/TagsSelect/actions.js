// @flow
export const selectTag = tags => {
  return {
    type: 'SELECT_TAG',
    tags
  }
}
