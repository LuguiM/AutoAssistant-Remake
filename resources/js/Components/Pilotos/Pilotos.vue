<template>
    <v-container class="fontPilotos">
        <div class="text-center mb-5 text-uppercase">
            <h3>Pilotos</h3>
        </div>

        <v-card class="busquedaStyle mb-5">
            <v-card-title class="text-center">
                Busqueda de Pilotos
            </v-card-title>

            <v-card-Text>
                <v-form>
                    <v-row>
                        <v-col cols="12" md="8">
                            <v-text-field label="Nombre del piloto" prepend-inner-icon="mdi-car-search"
                                class="inputStyle"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4" class="d-flex align-center justify-center mb-5">
                            <v-btn  prepend-icon="mdi-magnify" class="mr-3 blueButton">
                                Buscar
                            </v-btn>
                            <v-btn prepend-icon="mdi-trash-can" class="greyButton">
                                Limpiar
                            </v-btn>
                        </v-col>
                    </v-row>


                </v-form>
            </v-card-Text>
        </v-card>

        <v-row>
            <v-col v-for="piloto in pilotos" cols="12" md="3" sm="6">
                <v-card class="text-center card_piloto">
                    <v-img class="img_piloto" :src="piloto.img"></v-img>

                    <v-card-title class="card_title_p">
                        {{ piloto.titulo }}
                    </v-card-title>

                    <v-card-actions>
                        <v-btn block prepend-icon="mdi-car-info" class="btn-piloto" variant="outlined"
                            :to="{ path: '/verPiloto/' + piloto.id }">
                            Ver detalles</v-btn>
                    </v-card-actions>
                </v-card>

            </v-col>
        </v-row>


    </v-container>
</template>
<script setup>
import { ref } from 'vue';

const pilotos = ref([
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        titulo: 'Intermitente y luces de emergencia',
        id: '1'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        titulo: 'Precion del aire',
        id: '2'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        titulo: 'Servodireccion Electrica',
        id: '3'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        titulo: 'Luz Antiniebla',
        id: '4'
    },
    {
        img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
        titulo: 'Puertas abiertas',
        id: '5'
    },
])
</script>

<style>
.fontPilotos {
    color: #FFFFFF !important;
}

.busquedaStyle {
    background-color: #303134;
    color: #FFFFFF;
}


.card_piloto {
    height: 100%;
    max-width: 200px;
    margin: 0 auto;
    filter: brightness(50%);
    transition: filter 0.3s;
    border-radius: 10px;
    background-color: #242424;
    color: #FFFFFF;
}

.img_piloto {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
}

.card_title_p {
    white-space: normal;
    min-height: 112px;
    max-height: 112px;
}

.btn-piloto {
    color: #1279C1;
}


.card_piloto:hover {
    filter: brightness(100%);
    transform: scale(1.05);
    transition: transform .3s ease-out 0s;
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
}

.card_piloto:hover .card_title_p {
    opacity: 0;
    transition: 0.5s;
}

.card_piloto:hover .btn-piloto {
    color: #FFFFFF;
    background-color: #1279C1;
}
</style>