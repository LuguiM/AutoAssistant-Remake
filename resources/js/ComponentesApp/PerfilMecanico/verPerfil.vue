<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Perfil de Mecanico</h3>
        </div>

        <v-row>
            <v-col cols="12">
                <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
            </v-col>
            <v-col cols="12" sm="4">
                <v-card class="text-white bg-secondary">
                    <v-card-title class="text-center font-weight-bold mb-3">
                        <v-icon>mdi-account-circle</v-icon>
                        Información
                    </v-card-title>
                    <v-card-text>
                        <v-img :width="300" aspect-ratio="1/1" cover
                            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
                    </v-card-text>
                    <v-card-text class="mx-5">
                        <v-row>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Nombre del taller:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>Los 3</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Nombre del propietario:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>Kerin</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Numero de contacto:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>9876-5423</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p class="font-weight-bold">Direccion:</p>
                            </v-col>
                            <v-col cols="12" md="6">
                                <p>Las veraneras</p>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" sm="8">
                <v-card class="bg-terceary text-white">
                    <v-card-title class="text-center font-weight-bold">
                        <v-icon>mdi-car-cog</v-icon>
                        Servicios
                    </v-card-title>


                    <v-list lines="two" class="bg-terceary">
                        <v-list-item class="pb-0" v-for="servicio in serviciosMecanicos">
                            <v-card class="bg-primary">
                                <v-card-text>
                                    <v-row>
                                        <v-col cols="12" md="4" class="d-flex justify-center">
                                            <v-img :width="158" :height="158" :src="servicio.img"></v-img>
                                        </v-col>
                                        <v-col cols="12" md="8">
                                            <v-card-title>{{ servicio.title }}</v-card-title>
                                            <v-card-text>Tipo de servicio: {{ servicio.tipoServicio }}</v-card-text>
                                            <v-card-text class="text-end">Precio: ${{ servicio.precio }}</v-card-text>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-list-item>
                    </v-list>

                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

const perfilMecanico = ref([

]);

const serviciosMecanicos = ref([
    {
        img: "https://cdn.vuetifyjs.com/images/parallax/material.jpg",
        title: "Cambio de luces",
        tipoServicio: "Adomilicio",
        precio: "12"
    },
    {
        img: "https://cdn.vuetifyjs.com/images/parallax/material.jpg",
        title: "Cambio de luces",
        tipoServicio: "Adomilicio",
        precio: "12"
    }
])

</script>

<style></style>