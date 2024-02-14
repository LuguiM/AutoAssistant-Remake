import {defineStore} from 'pinia'
import notify from '../plugins/notify'

export const useAuthStore = defineStore('auth', {
    state: () => ({ authUser: null, authToken: null }),
    getters: {
        user:(state) => state.authUser,
        token:(state) => state.authToken
    },
    actions: {
        async getToken(){
            await axios.get('/sanctum/csfr-cookie');
        },
        async login(form){
            await this.getToken();
            await axios.post('/api/auth/login', form).then(
                (res) => {
                    this.authToken = res.data.token;
                    this.authUser = res.data.data;
                    this.router.push('/dashboard')
                }
            ).catch(
                (errors) => {
                    let desc = '';
                    errors.response.data.errors.map(
                        (e) => {desc = desc + ' '+e}
                    )
                    notify(desc,'error')
                }
            )
        },
        async resgister(form){
            await this.getToken();
            await axios.post('/api/auth/register', form).then(
                (res) => {
                    notify(res,'success')
                    setTimeout( () => this.router.push('/IniciarSesion'), 2000)
                    this.router.push('/IniciarSesion')
                }
            ).catch(
                (errors) => {
                    let desc = '';
                    errors.response.data.errors.map(
                        (e) => {desc = desc + ' '+e}
                    )
                    notify(desc,'error')
                }
            )
        },
        async logout(){
            await axios.get('/api/auth/logout', this.authToken);
            this.authToken = null;
            this.authUser = null;
            this.router.push('/IniciarSesion')
        }
    },
    persist: true
})
