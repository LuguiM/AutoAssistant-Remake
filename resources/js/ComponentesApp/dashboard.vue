<template>
    <v-container>

        <div class="mt-4 mb-6">
            <h1>Bienvenido a AutoAsisstant</h1>
            <p>Accesos rapidos</p>
        </div>
        
        <v-row v-if="authStore.authUser.rol == 'futuro_conductor' || authStore.authUser.rol == 'conductor'">
            <v-col cols="12" sm="6" md="4" v-for="(ruta, index) in rutasConductor" :key="index">
                <v-card @click="goRuta(ruta.ruta)" class="bg-primary d-flex align-center justify-center text-h6" variant="outlined" height="100" hover>
                    <v-row>
                        <v-col cols="12" sm="4" class="text-center">
                            <v-icon>{{ ruta.icon }}</v-icon>
                        </v-col>
                        <v-col cols="12" sm="8" class="text-center text-sm-start">
                            {{ ruta.nombre }}
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
        
        <v-row v-else-if="authStore.authUser.rol == 'admin'">
            <v-col cols="12" sm="6" md="4" v-for="(ruta, index) in items" :key="index">
                <v-card @click="goRuta(ruta.ruta)" class="bg-primary d-flex align-center justify-center text-h6" variant="outlined" height="100" hover>
                    <v-row>
                        <v-col cols="12" sm="5" class="text-center">
                            <v-icon>{{ ruta.icon }}</v-icon>
                        </v-col>
                        <v-col cols="12" sm="7" class="text-center text-sm-start">
                            {{ ruta.nombre }}
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>

        <v-row v-else >
            <v-col cols="12" sm="6" md="4" v-for="(ruta, index) in rutasMecanico" :key="index">
                <v-card @click="goRuta(ruta.ruta)" class="bg-primary d-flex align-center justify-center text-h6" variant="outlined" height="100" hover>
                    <v-row>
                        <v-col cols="12" sm="4" class="text-center">
                            <v-icon>{{ ruta.icon }}</v-icon>
                        </v-col>
                        <v-col cols="12" sm="8" class="text-center text-sm-start">
                            {{ ruta.nombre }}
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import notify from '@/plugins/notify.js';
import { useAuthStore } from '@/Stores/auth';



const router = useRoute();
const routerPush = useRouter();
const authStore = useAuthStore();

const items = ref([
    { nombre: 'Perfil', icon: 'mdi-account-circle', ruta: 'perfilUsuario' },
    { nombre: 'Inscripción Servicios', icon: 'mdi-progress-wrench', ruta: 'inscripcionServicios' },
    { nombre: 'Servicios Contratados', icon: 'mdi-wrench-check', ruta: 'serviciosContratados' },
    { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: 'manuales' },
    { nombre: 'Pilotos', icon: 'mdi-car', ruta: 'Pilotos' },
    { nombre: 'Servicios Mecanicos', icon: 'mdi-car-wrench', ruta: 'servicios-mecanicos' },
    { nombre: 'Servicios Activos', icon: 'mdi-wrench-clock', ruta: 'serviciosActivos' },
    { nombre: 'Perfil Mecanico', icon: 'mdi-account-cog', ruta: 'crearPerfilMecanico' },
]);

const rutasConductor = ref([
    { nombre: 'Perfil', icon: 'mdi-account-circle', ruta: 'perfilUsuario' },
    { nombre: 'Pilotos', icon: 'mdi-car', ruta: 'Pilotos' },
    { nombre: 'Servicios Mecanicos', icon: 'mdi-car-wrench', ruta: 'servicios-mecanicos' },
    { nombre: 'Servicios Contratados', icon: 'mdi-wrench-check', ruta: 'serviciosContratados' },
]);

const rutasMecanico = ref([
    { nombre: 'Perfil', icon: 'mdi-account-circle', ruta: 'perfilUsuario' },
    { nombre: 'Inscripción Servicios', icon: 'mdi-progress-wrench', ruta: 'inscripcionServicios' },
    { nombre: 'Servicios Activos', icon: 'mdi-wrench-clock', ruta: 'serviciosActivos' },
    { nombre: 'Perfil Mecanico', icon: 'mdi-account-cog', ruta: 'perfilMecanico' },
    { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: 'manuales' },
    { nombre: 'Pilotos', icon: 'mdi-car', ruta: 'Pilotos' },
]);

const goRuta = (ruta) => {
    routerPush.push({ path: ruta })
}

</script>
<style></style>