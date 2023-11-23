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
                    <v-text-field label="Nombre del piloto" prepend-inner-icon="mdi-car-search"
                        class="inputStyle"></v-text-field>
                    <v-btn variant="tonal" class="mr-2 btn-buscar">
                        Buscar
                    </v-btn>
                    <v-btn variant="tonal" class="btn-limpiar">
                        Limpiar
                    </v-btn>
                </v-form>
            </v-card-Text>
        </v-card>

        <v-row>
            <v-col v-for="piloto in pilotos" cols="12" md="3" sm="6">
                <v-card class="text-center card_piloto">
                    <v-img class="img_piloto" :src="piloto.img"></v-img>

                    <v-card-title style="white-space: normal;">
                        {{ piloto.titulo }}
                    </v-card-title>

                    <v-card-actions>
                        <v-btn block class="btn-piloto" variant="outlined">Ver detalles</v-btn>
                    </v-card-actions>
                </v-card>

            </v-col>
        </v-row>


    </v-container>
</template>

<script>
export default {

    data() {
        return {
            pilotos: [
                {
                    img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
                    titulo: 'Advertencia del Airbag',
                    id: '1'
                },
                {
                    img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
                    titulo: 'Precion del aire',
                    id: '1'
                },
                {
                    img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
                    titulo: 'Servodireccion Electrica',
                    id: '1'
                },
                {
                    img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
                    titulo: 'Luz Antiniebla',
                    id: '1'
                },
                {
                    img: 'https://cdn.vuetifyjs.com/images/cards/cooking.png',
                    titulo: 'Puertas abiertas',
                    id: '1'
                },
            ]
        }
    }

}
</script>

<style scoped>
.fontPilotos {
    color: #FFFFFF !important;

}

.busquedaStyle {
    background-color: #303134;
    color: #FFFFFF;
}

.btn-buscar {
    background-color: #1279C1;
    color: #FFFFFF;
}

.btn-limpiar {
    background-color: #242424;
    color: #FFFFFF;
}

.card_piloto {
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

.card_piloto:hover {
    filter: brightness(100%);
}

.card_piloto:hover .card_title_p {
    color: initial;
}

.btn-piloto {
    color: #1279C1;
}
</style>