<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Detalle del servicio</h3>
        </div>
        <v-row>
            <v-col cols="12">
                <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
            </v-col>
            <v-col cols="12">
                <v-card variant="outlined" class="cardServicio">
                    <v-row>
                        <v-col col="12" md="4" class="d-flex align-center justify-center">

                            <v-img class="ml-1" style="height: 70%;"
                                src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
                        </v-col>

                        <v-col col="12" md="8">
                            <v-card-title class="text-h5 bg-primary text-center font-weight-bold">
                                Intermitente y luces de emergencia
                            </v-card-title>

                            <v-card-Text class="mt-5">
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Descripcion del servicio:</h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, ratione debitis
                                        quis est
                                        labore voluptatibus! Eaque cupiditate minima
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Tipo de servicio: </h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        Cita/Reserva
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Horario:</h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        Lunes - Miercoles <br>
                                        5:00 pm - 4:00 am
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Dirección:</h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        La veraneras
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Rubro:</h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        Lubricentro
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Numero de contacto:</h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        2345-6505
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <h3 class="font-weight-bold">Precio del servicio:</h3>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        $ 125
                                    </v-col>

                                    <v-col cols="12" class="d-flex justify-end">
                                        <v-btn class="blueButton" prepend-icon="mdi-account">Perfil</v-btn>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-btn variant="outlined" block class="text-primary btnContratar"
                                            prepend-icon="mdi-wrench-cog">Contratar servicio</v-btn>
                                    </v-col>
                                </v-row>

                            </v-card-Text>

                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {

    data() {
        return {

        }
    }

}
</script>

<style>
.cardServicio {
    background-color: #242424;
    border: #1279C1 solid 2px;
}

.btnContratar:hover {
    background-color: #1279C1;
    color: #FFFFFF !important;
}
</style>