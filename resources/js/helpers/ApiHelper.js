export const getRequest = (url) => {
   return axios.get(url, {
        headers: {
            authorization: "Bearer " + localStorage.getItem("token"),
        },
    }).then(res => res.data);
};