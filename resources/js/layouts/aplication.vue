<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" class="bgBar"
            :permanent="$vuetify.theme.currentBreakpoint >= $vuetify.theme.mobileBreakpoint"
            :temporary="$vuetify.theme.currentBreakpoint < $vuetify.theme.mobileBreakpoint">
            <v-list>
                <v-list-item class="d-flex justify-center">

                    <v-img :width="120" cover src="../images/Logos/sinLetrasLogo.png"></v-img>
                    <label class="text-uppercase font-weight-bold">AutoAssistant</label>


                </v-list-item>
            </v-list>

            <v-divider></v-divider>
            <v-list nav density="compact">
                <v-list-item v-show="authStore.user.rol == 'conductor' || authStore.user.rol == 'futuro_conductor'" class="font-weight-bold" v-for="(item, index) in rutasConductor" :to="item.ruta" :key="index"
                    :prepend-icon="item.icon">
                    {{ item.nombre }}
                </v-list-item>
                <v-list-item v-show="authStore.user.rol == 'Mecanico Independiente' || authStore.user.rol == 'Taller Mecanico'" class="font-weight-bold" v-for="(item, index) in rutasMecanico" :to="item.ruta" :key="index"
                    :prepend-icon="item.icon">
                    {{ item.nombre }}
                </v-list-item>
                <v-list-item v-show="authStore.user.rol == 'admin'" class="font-weight-bold" v-for="(item, index) in items" :to="item.ruta" :key="index"
                    :prepend-icon="item.icon">
                    {{ item.nombre }}
                </v-list-item>
            </v-list>

            <template v-slot:append>
                <div class="pa-2 ">
                    <v-btn block class="bgBar" flat @click="$event => authStore.logout()">
                        <v-icon start icon="mdi-exit-to-app"></v-icon>
                        Cerrar Sesión
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-app-bar class="appNav" dense>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            </v-app-bar-nav-icon>

            <v-spacer></v-spacer>


            <h5 style="padding: 5px 13px;">
                <v-icon start icon="mdi-account-circle"></v-icon>
                {{ authStore.user.nombre }}
            </h5>
        </v-app-bar>

        <v-main class="bgMain">
            <router-view />
        </v-main>

    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../Stores/auth'

const authStore = useAuthStore();

const items = ref([
    { nombre: 'Inicio', icon: 'mdi-home', ruta: '/dashboard' },
    { nombre: 'Perfil', icon: 'mdi-account', ruta: '/perfilUsuario' },
    { nombre: 'Inscripción Servicios', icon: 'mdi-progress-wrench', ruta: '/inscripcionServicios' },
    { nombre: 'Servicios Contratados', icon: 'mdi-wrench-check', ruta: '/serviciosContratados' },
    { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: '/manuales' },
    { nombre: 'Pilotos', icon: 'mdi-car', ruta: '/Pilotos' },
    { nombre: 'Servicios Mecanicos', icon: 'mdi-car-wrench', ruta: '/servicios-mecanicos' },
    { nombre: 'Servicios Activos', icon: 'mdi-wrench-clock', ruta: '/serviciosActivos' },
    { nombre: 'Perfil Mecanico', icon: 'mdi-account', ruta: '/crearPerfilMecanico' },
]);

const rutasConductor = ref([
    { nombre: 'Inicio', icon: 'mdi-home', ruta: '/dashboard' },
    { nombre: 'Perfil', icon: 'mdi-account', ruta: '/perfilUsuario' },
    { nombre: 'Pilotos', icon: 'mdi-car', ruta: '/Pilotos' },
    { nombre: 'Servicios Mecanicos', icon: 'mdi-car-wrench', ruta: '/servicios-mecanicos' },
    { nombre: 'Servicios Contratados', icon: 'mdi-wrench-check', ruta: '/serviciosContratados' },
]);

const rutasMecanico = ref([
    { nombre: 'Inicio', icon: 'mdi-home', ruta: '/dashboard' },
    { nombre: 'Perfil', icon: 'mdi-account', ruta: '/perfilUsuario' },
    { nombre: 'Inscripción Servicios', icon: 'mdi-progress-wrench', ruta: '/inscripcionServicios' },
    { nombre: 'Servicios Activos', icon: 'mdi-wrench-clock', ruta: '/serviciosActivos' },
    { nombre: 'Perfil Mecanico', icon: 'mdi-account', ruta: '/crearPerfilMecanico' },
    { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: '/manuales' },
    { nombre: 'Pilotos', icon: 'mdi-car', ruta: '/Pilotos' },
]);
const drawer = ref(true);
</script>
<style>
.bgBar {
    background-color: #242424 !important;
    color: #1279C1;
}

.appNav {
    background-color: #1279C1 !important;
    color: #FFFFFF !important;
}

.bgMain {
    /* background: url('../images/Fondos/fondo4.jpg') no-repeat center center fixed;
    background-size: cover; */
    background-color: #32525C;
}
</style>