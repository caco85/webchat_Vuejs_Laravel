import { createStore  } from 'vuex'
import axios from 'axios'
import cretePersistedState from 'vuex-persistedstate'


const state ={
    user: {}
}
const mutations = {
    setUserState: (state, value) => state.user = value
}

const actions = {
    userStateAction: ({commit}) => {
        axios.get('api/user/me').then(response => {
            const userResponse = response.data.user
            commit('userStateAction', userResponse)
        })
    }
}

export default createStore({
    state,
    mutations,
    actions,
    plugins: [cretePersistedState ()]
})
