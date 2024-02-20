<template>
    <div>

        <crearPerfilMecanico v-if="!status"></crearPerfilMecanico>

        <verPerfil v-else></verPerfil>

    </div>
</template>

<script setup>
import crearPerfilMecanico from './crearPerfilMecanico.vue'
import verPerfil from './verPerfil.vue'
import { ref, onMounted } from 'vue';
import { getData } from '@/plugins/api.js'
import { useAuthStore } from '@/Stores/auth';
import notify from '@/plugins/notify.js';


const authStore = useAuthStore();
const status = ref(false);


const getPerfil = async () => {

    const id = authStore.authUser.id

    const data = await getData(('verificarPerfil/' + id));
    status.value = data.status;

    if(!status.value){
        notify(data.message, data.alert)
    }
    console.log(data.message)

}


onMounted(() => {
    getPerfil()
});

</script>
