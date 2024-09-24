import {ref, inject} from 'vue'
import {useRouter} from 'vue-router'

export default function useRecipients() {
    const recipient = ref({})
    const recipients = ref({})
    const validationErrors = ref({})
    const isLoading = ref(false)
    const router = useRouter()
    const swal = inject('$swal')

    const getRecipients = async() => {
        axios.get('/api/recipients')
        .then(response => {
            recipients.value = response.data.data
        })
    }
    const storeRecipient = async(recipient) => {
        if(isLoading.value) return;
        isLoading.value = true;
        validationErrors.value = {}

        axios.post('/api/recipients', recipient)
        .then(response => {
            swal({
                icon: 'success',
                title: 'Recipient saved successfully'
            })
            router.push({name: 'credits.create', query: {recipient_id: response.data.data.id}})
        })
        .catch(error => {
            if(error.response?.data) {
                validationErrors.value = error.response.data.errors
                isLoading.value = false;
            }
        })
    }

    const getRecipient = async (id) => {
        axios.get('/api/recipients/' + id)
            .then(response => {
                recipient.value = response.data.data;
            })
    }

    return {recipient, getRecipient, recipients, getRecipients, storeRecipient, isLoading, validationErrors}
}
