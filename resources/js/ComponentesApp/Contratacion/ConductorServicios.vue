<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Servicios Contratados</h3>
        </div>

        <v-card class="busquedaStyle mb-5">
            <v-card-Text>
                <v-form>
                    <v-row>
                        <v-col cols="12" md="6">
                                <v-select
                                    prepend-inner-icon="mdi-car-search"
                                    label="Estado"
                                    :items="[ 'Activo', 'En espera', 'Cancelado', 'Completado']"
                                    variant="solo"
                                    hide-details="auto"
                                ></v-select>
                        </v-col>
                        <v-col cols="12" md="5" class="d-flex flex-column flex-sm-row align-center justify-center justify-md-start" style="gap:10px;">
                            <v-btn  prepend-icon="mdi-magnify" class="blueButton px-8">
                                Buscar
                            </v-btn>
                            <v-btn prepend-icon="mdi-trash-can" class="greyButton px-8">
                                Limpiar
                            </v-btn>
                        </v-col>
                    </v-row>


                </v-form>
            </v-card-Text>
        </v-card>

        <v-row>
            <v-col cols="12" sm="6" v-for="(servicio, index) in servicios" :key="index">
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
                                <v-card-text>
                                    Estado:
                                    <v-chip variant="elevated" :color="servicio.color" class="ma-2" :prepend-icon="servicio.icon">
                                        {{servicio.estado}}
                                    </v-chip>
                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="d-flex flex-column flex-sm-row justify-space-between gap-10"  v-if="servicio.estado === 'Activo'">
                        <div class="d-flex flex-column flex-md-row gap-10" >
                            <CancelarRechazar title="Cancelar" type="text"></CancelarRechazar>                                  
                        </div>
                    
                        <v-btn class="bg-grey2" prepend-icon="mdi-message-outline">Chat</v-btn>
                    </v-card-actions>
                    <v-card-actions class="d-flex flex-column flex-sm-row justify-space-between gap-10"  v-else-if="servicio.estado === 'En espera'">
                        <div class="d-flex flex-column flex-md-row gap-10" >
                            <v-btn class="bg-primary"  prepend-icon="mdi-square-edit-outline">Modificar</v-btn>
                            <CancelarRechazar title="Cancelar" type="text"></CancelarRechazar>                                  
                        </div>

                        <Observacion title="Ver" type="text"></Observacion>
                    </v-card-actions>

                    <v-card-actions class="d-flex justify-space-between" v-else-if="servicio.estado === 'Rechazado'">
                        <div class="d-flex flex-column flex-sm-row gap-10" >
                            <VerRechazo type="text"></VerRechazo>
                        </div>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import Observacion from '../../Components/Modales/Observacion.vue';
import VerRechazo from '../../Components/Modales/VerRechazo.vue';
import CancelarRechazar from '../../Components/Modales/CancelarRechazar.vue';


const servicios = ref([
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Intermitente ',
        created_at: '12/09/2023',
        estado: 'Activo',
        color:'primary',
        icon: 'mdi-cogs'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'luces de emergencia',
        created_at: '12/09/2023',
        estado:'En espera',
        color:'grey',
        icon:'mdi-clock-outline'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Emergencia',
        created_at: '12/09/2023',
        estado:'Completado',
        color:'green',
        icon:'mdi-checkbox-marked-circle-outline'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Intermitente y luces',
        created_at: '12/09/2023',
        estado:'Cancelado',
        color:'red',
        icon:'mdi-delete-outline'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        title: 'Intermitente y luces de emergencia',
        created_at: '12/09/2023',
        estado:'Rechazado',
        color:'orange-darken-4',
        icon:'mdi-close-circle-outline'
    },
])

</script>

<style>
.v-card-actions .v-btn ~ .v-btn:not(.v-btn-toggle .v-btn) {
    margin-inline-start: 0 !important; 
}

.v-table__wrapper thead{
    background-color: #1279C1;
    color: #FFFFFF;
}
</style>