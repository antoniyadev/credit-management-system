import {ref} from 'vue'

export default function useRecipients() {
    const recipients = ref({})
    const getRecipients = async() => {
        axios.get('/api/recipients')
        .then(response => {
            recipients.value = response.data.data
        })
    }
    return {recipients, getRecipients}
}
