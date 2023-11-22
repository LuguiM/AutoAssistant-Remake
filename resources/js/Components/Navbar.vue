<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" class="bg-deep-purple" theme="dark" permanent>
            <v-list v-for="item in items">
                <v-list-item :to="item.ruta" :prepend-icon="item.icon">
                    {{ item.nombre }}
                </v-list-item>
            </v-list>

            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block>
                        Logout
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-app-bar color="info">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            </v-app-bar-nav-icon>
        </v-app-bar>

        <main>
            <RouterView />
        </main>

    </v-app>
</template>

<script>
export default {
    data() {
        return {
            items: [
                { nombre: 'Inicio', icon: 'mdi-view-dashboard', ruta: '/' },
                { nombre: 'Contacto', icon: 'mdi-account-box', ruta: '/contacto' }
            ],
            drawer: true,
        }
    },
}
</script>