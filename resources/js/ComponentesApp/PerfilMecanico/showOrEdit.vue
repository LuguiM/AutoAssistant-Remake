<template>
    <div>

        <v-overlay class="align-center justify-center" v-if="loading" :model-value="loading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>


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
