<template>
    <v-app>
        <v-app-bar app flat class="bgMainHeader" height="90">
            

            <v-app-bar-title class="d-flex flex-row">
                <v-img src="../images/Logos/sinLetrasLogo.png" height="40" class=""></v-img>
                AutoAssistant
            </v-app-bar-title>

            <template v-slot:append>
                <div class="d-none d-sm-block">
                    <v-btn prepend-icon="mdi-login" to="/IniciarSesion">Iniciar Sesión</v-btn>
                    <v-btn prepend-icon="mdi-account-plus">Registrarse</v-btn>
                </div>
                <div class="d-block d-sm-none">
                    <v-btn to="/IniciarSesion" icon>
                        <v-icon>mdi-login</v-icon>
                    </v-btn>
                    <v-btn icon>
                        <v-icon>mdi-account-plus</v-icon>
                    </v-btn>
                </div>
                
            </template>

        </v-app-bar>


        <v-app-bar app class="bgHeader">
            
            <v-app-bar-nav-icon class="d-block d-sm-none" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            
            <v-tabs class="d-none d-sm-flex" center-active show-arrows>
                <v-tab v-for="(item, index) in items" :key="index" :to="item.ruta">
                <v-icon>{{ item.icon }}</v-icon>
                {{ item.nombre }}
                </v-tab>
            </v-tabs>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            temporary
            class="bgNav d-block d-sm-none"
        >

            <v-list density="compact" nav>
                <v-list-item v-for="(item, index) in items" :key="index" :prepend-icon="item.icon" :to="item.ruta" :title="item.nombre"></v-list-item>
            </v-list>
      </v-navigation-drawer>

        
        <v-main class="bgWeb">
            <router-view />
        </v-main>

        <v-footer class="bg-terceary">
            <v-row justify="center">
                <v-col cols="12" sm="6">

                </v-col>
                <v-col cols="12" sm="6">

                </v-col>
                <v-col cols="12" class="text-center">
                    {{ new Date().getFullYear() }} — <strong>AutoAssistant</strong>
                </v-col>
            </v-row>
        </v-footer>
    </v-app>
</template>
  
  
  
  

<script>
export default {
    data() {
        return {
            items: [
                { nombre: 'Inicio', icon: 'mdi-home', ruta: '/principal' },
                { nombre: 'Nosotros', icon: 'mdi-account-box', ruta: '/s' },
                { nombre: 'Nuestros servicios', icon: 'mdi-car-wrench', ruta: '/d' },
                { nombre: 'Pilotos', icon: 'mdi-car', ruta: '/PilotosWeb' },
                { nombre: 'Servicios mecanicos', icon: 'mdi-car-search', ruta: '/servicios-mecanicosWeb' },
                { nombre: 'Requisitos', icon: 'mdi-playlist-check', ruta: '/w' },
                { nombre: 'Manuales', icon: 'mdi-bookshelf', ruta: '/servicios' },
            ],
            drawer: false,
        }
    },
}
</script>

<style >
.bgHeader {
    background-color: #242424 !important;
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

.bgNav {
    background-color: #242424 !important;
    color: #FFFFFF !important;
}
</style>