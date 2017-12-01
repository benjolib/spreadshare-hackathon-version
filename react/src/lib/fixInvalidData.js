// @flow

const fixInvalidData = (data: Object) => {
  const invalidRows = {};

  const validData = {
    ...data,
    rows: data.rows.filter(row => {
      if (!row.content) {
        invalidRows[row.id] = row.id;
        return false;
      }
      return true;
    }),
    votes: data.votes.filter(vote => {
      if (invalidRows[vote.rowId]) {
        return false;
      }
      return true;
    })
  };

  return validData;
};

export default fixInvalidData;
