<template>
    <v-app>
        <v-app-bar app flat class="bgMainHeader" height="90">

            <v-img src="../images/Logos/sinLetrasLogo.png" height="40" class=""></v-img>
            <h3>AutoAssistant</h3>

            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            
            <v-btn prepend-icon="mdi-login">Iniciar Sesión</v-btn>
            <v-btn prepend-icon="mdi-account-plus">Registrarse</v-btn>

        </v-app-bar>


        <v-app-bar app class="bgHeader">
            <v-btn v-for="item in items" :prepend-icon="item.icon">{{ item.nombre }}</v-btn>
        </v-app-bar>
        <v-main class="bgWeb">
            <router-view />
        </v-main>
    </v-app>
</template>
  
  
  
  

<script>
export default {
    data() {
        return {
            items: [
                { nombre: 'Inicio', icon: 'mdi-home', ruta: '/' },
                { nombre: 'Nosotros', icon: 'mdi-account-box', ruta: '/home' },
                { nombre: 'Servicio que ofrece', icon: 'mdi-car-wrench', ruta: '/' },
                { nombre: 'Pilotos', icon: 'mdi-car', ruta: '/pilotos' },
                { nombre: 'Busqueda de servicios', icon: 'mdi-car-search', ruta: '/' },
                { nombre: 'Requisitos', icon: 'mdi-playlist-check', ruta: '/' },
                { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: '/servicios' },
            ],
            drawer: true,
        }
    },
}
</script>

<style >
.bgHeader {
    background-color: #000000 !important;
    color: #FFFFFF !important;
    border-top: #FFFFFF solid 1px;
    border-bottom: #FFFFFF solid 1px;
}

.bgMainHeader {
    background-color: #1279C1 !important;
    color: #FFFFFF !important;
}

.bgWeb {
    background: url('../images/Fondos/fondo4.jpg') no-repeat center center fixed;
    background-size: cover;
}
</style>