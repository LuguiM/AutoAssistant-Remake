<template>
    <div>

        <v-row v-if="loading" v-model="loading" class="fill-height" align-content="center" justify="center">
            <v-col class="text-subtitle-1 text-center text-white" cols="12">
                Cargando datos...
            </v-col>
            <v-col cols="6">
                <v-progress-linear color="white" indeterminate rounded height="6"></v-progress-linear>
            </v-col>
        </v-row>


        <crearPerfilMecanico v-else-if="!status"></crearPerfilMecanico>
        <verPerfil v-else-if="status" mode="mecanico" :id="authStore.authUser.id"></verPerfil>
    </div>
</template>

<script setup>
import crearPerfilMecanico from './crearPerfilMecanico.vue'
import verPerfil from './verPerfil.vue'
import { ref, onMounted } from 'vue';
import { getData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';
import notify from '@/plugins/notify.js';

const authStore = useAuthStore();
const status = ref(false);
const loading = ref(true);

const getPerfil = async () => {
    try {
        const id = authStore.authUser.id;
        const data = await getData(('verificarPerfil/' + id));
        status.value = data.status;
        if (!status.value) {
            notify(data.message, data.alert);
        }
        console.log(data.message);
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    getPerfil();
});
</script>
