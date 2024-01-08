import { form } from '@/customerState'

export const  getAddress = async (postcode) => {
    await axios.get(`/api/retrieve-address/${postcode}`)
        .then(res => {
            form.address = res.data.address
        })
        .catch(error => {
            // TODO: Errorの表示
            console.log(res.response.data.message);
        })
}