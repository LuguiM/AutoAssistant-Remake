<template>
    <v-container class="custom-container">
        <v-row>
            <v-col cols="12" sm="6" offset-sm="3">
                <v-card class="my-5 pa-5 text-center bg-black" rounded="xl">
                    <v-card-title>
                        <v-img src="../images/Logos/sinLetrasLogo.png" height="100"></v-img>
                        <h5>AutoAssistant</h5>
                    </v-card-title>

                    <v-card-title class="text-h4 item-texto mb-3">
                        Opciones de registro
                    </v-card-title>

                    <v-card-text class="d-flex flex-column">
                        <v-btn class="bg-primary mb-3">Conductor y <br> futuro conductor</v-btn>
                        <v-btn class="bg-primary">Taller mecanico y <br> mecanico independiente</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

</script>

<style>

</style>