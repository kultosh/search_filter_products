export const getRequest = (url) => {
   return axios.get(url, {
        headers: {
            authorization: "Bearer " + localStorage.getItem("token"),
        },
    }).then(res => res.data);
};

export const postRequest = (url, data) => {
    return axios.post(url, data).then(res => res.data).catch(err => err.response.data);
}