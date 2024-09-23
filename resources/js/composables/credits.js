import {ref, inject} from 'vue'
import {useRouter} from 'vue-router'

export default function useCredits() {
    const credits = ref({})
    const creditsForPayment = ref({})
    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')
    const credit = ref({})

    const storeCredit = async(credit) => {
        if(isLoading.value) return;
        isLoading.value = true;
        validationErrors.value = {}

        axios.post('/api/credits', credit)
        .then(response => {
            router.push({name: 'credits.index'})
            swal({
                icon: 'success',
                title: 'Credit saved successfully'
            })
        })
        .catch(error => {
            if(error.response?.data) {
                validationErrors.value = error.response.data.errors
                isLoading.value = false;
            }
        })
    }

    const getCredit = async (id) => {
        axios.get('/api/credits/' + id)
            .then(response => {
                credit.value = response.data.data;
            })
    }

    const getCredits = async(page=1,order_column='created_at',order_direction='desc') => {
        axios.get('/api/credits?page=' + page + '&order_column=' + order_column + '&order_direction=' + order_direction)
        .then(response => {
            credits.value = response.data;
        })
    }

    const getCreditsForPayment = async() => {
        axios.get('/api/credits/for-payment')
        .then(response => {
            creditsForPayment.value = response.data.data
        })
    }

    const storePayment = async(creditId, amount) => {
        if(isLoading.value) return;
        isLoading.value = true;
        validationErrors.value = {}

        let payment = { credit_id: creditId, amount: amount }
        axios.post('/api/payments', payment)
        .then(response => {
            let title = response.data.data.is_amount_exceeded ?
             'Success, but the amount exceeded the remaining amount of the credit' :
             'Payment has been added successfully'
            swal({
                icon: 'success',
                title: title
            })
            router.push({name: 'credits.index'})
        })
        .catch(error => {
            if(error.response?.data) {
                validationErrors.value = error.response.data.errors
                isLoading.value = false;
            }
        })
    }
    return {credit, credits, getCredit, getCredits, creditsForPayment, getCreditsForPayment, storeCredit, validationErrors, isLoading, storePayment}
}
