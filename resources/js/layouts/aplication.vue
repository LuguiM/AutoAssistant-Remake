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
                <v-list-item class="font-weight-bold" v-for="item in items" :to="item.ruta" :prepend-icon="item.icon">
                    {{ item.nombre }}
                </v-list-item>
            </v-list>

            <template v-slot:append>
                <div class="pa-2 ">
                    <v-btn block class="bgBar" flat>
                        <v-icon start icon="mdi-exit-to-app"></v-icon>
                        Cerrar Sesión
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-app-bar class="appNav" dense>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            </v-app-bar-nav-icon>
            <v-img aspect-ratio="16/9" src="../images/Logos/LogoBN.png"></v-img>
            <v-img src="../images/Logos/LogonBlancoNegro.png"></v-img>


            <v-spacer></v-spacer>

            <h5 style="padding: 5px 13px;">
                <v-icon start icon="mdi-account-circle"></v-icon>
                Kerin Melendez
            </h5>
        </v-app-bar>

        <v-main class="bgMain">
            <router-view />
        </v-main>

    </v-app>
</template>

<script>
export default {
    data() {
        return {
            items: [
                { nombre: 'Inicio', icon: 'mdi-home', ruta: '/dashboard' },
                { nombre: 'Perfil', icon: 'mdi-account', ruta: '/homesite' },
                { nombre: 'Inscripción Servicios', icon: 'mdi-progress-wrench', ruta: '/servicios' },
                { nombre: 'Servicios Activos', icon: 'mdi-wrench-check', ruta: '/serviciosActivos' },
                { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: '/servicios' },
                { nombre: 'Pilotos', icon: 'mdi-car', ruta: '/Pilotos' },
                { nombre: 'Servicios Mecanicos', icon: 'mdi-car-wrench', ruta: '/serviciosMecanicos' },
                { nombre: 'Servicios Activos', icon: 'mdi-wrench-clock', ruta: '/serviciosActivos' },

            ],
            drawer: true,
        }
    },
}
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
    background: url('../images/Fondos/fondo4.jpg') no-repeat center center fixed;
    background-size: cover;
}
</style>