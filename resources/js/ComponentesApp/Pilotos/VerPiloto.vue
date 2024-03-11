<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Detalle del piloto</h3>
        </div>

        <v-row>
            <v-col cols="12">
                <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
            </v-col>
            <v-col cols="12">
                <v-card class="pilotoDetail">
                    <v-row>
                        <v-col cols="12" md="5" class="d-flex align-center justify-center">
                            <v-card-text >
                                <v-img class="" src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
                            </v-card-text>
                        </v-col>

                        <v-col cols="12" md="7">
                          <v-card-text>
                            <v-card-title class="text-h5 font-weight-bold bg-primary rounded-lg mb-5">
                                Intermitente y luces de emergencia
                            </v-card-title>

                            <v-card-Text>
                                <h3>Descripcion</h3>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, ratione debitis quis est
                                labore voluptatibus! Eaque cupiditate minima
                            </v-card-Text>

                            <v-card-text>
                                <v-expansion-panels color="primary">
                                    <v-expansion-panel title="Solución"
                                        text="Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, ratione debitis quis est labore voluptatibus! Eaque cupiditate minima">
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </v-card-text>
                        </v-card-text>

                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

</script>

<style>
.pilotoDetail {
    background-color: #303134;
    color: #FFFFFF;
}
</style>