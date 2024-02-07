<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Servicios Contratados</h3>
        </div>

        <v-row>
            <v-col cols="12" sm="6" v-for="(servicio, index) in serviciosConductor" :key="index">
                <v-card class="bg-secondary">
                    <v-card-text>
                        <v-row align="center">
                            <v-col cols="12" sm="4">
                                <v-img :src="servicio.img" max-height="200"></v-img>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <v-card-title class="text-h5 font-weight-bold item-texto">
                                    {{ servicio.title }}
                                </v-card-title>
                                <v-card-subtitle class="item-texto">
                                    Fecha de contratación: {{ servicio.created_at }}
                                </v-card-subtitle>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-space-between">
                        <div class="d-flex flex-column flex-sm-row" style="gap: 10px;">
                            <v-btn class="bg-primary"  prepend-icon="mdi-square-edit-outline">Modificar</v-btn>
                            <v-btn class="bg-error" prepend-icon="mdi-delete-outline">Cancelar</v-btn>
                        
                        </div>
                       
                        <v-btn class="bg-grey2" prepend-icon="mdi-message-outline">Chat</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

const serviciosConductor = ref([
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Intermitente y luces de emergencia',
        created_at: '12/09/2023',
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Intermitente y luces de emergencia',
        created_at: '12/09/2023',
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Intermitente y luces de emergencia',
        created_at: '12/09/2023',
    },
])

</script>

<style>
.v-card-actions .v-btn ~ .v-btn:not(.v-btn-toggle .v-btn) {
    margin-inline-start: 0 !important; 
}
</style>