<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Crear perfil mecanico</h3>
        </div>

        <v-row>
            <v-col cols="12">
                <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
            </v-col>
            <v-col cols="12">
                <v-card class="bg-greyDark">
                    <v-card-title class="text-center">
                        <v-avatar image="https://cdn.vuetifyjs.com/images/cards/cooking.png" size="150"></v-avatar>
                        <v-file-input :rules="rules" accept="image/png, image/jpeg, image/bmp" placeholder="Pick an avatar"
                            prepend-icon="mdi-camera" label="Avatar" color="primary" variant="solo"></v-file-input>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-text-field label="Nombre del taller" color="primary" variant="solo"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="5">
                                <v-text-field label="Nombre del propietario" color="primary" variant="solo"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="1">
                                <v-tooltip text="Establecer nombre de la cuenta">
                                    <template v-slot:activator="{ props }">
                                        <v-btn class="bg-secondary"
                                            v-bind="props"><v-icon>mdi-tooltip-account</v-icon></v-btn>
                                    </template>
                                </v-tooltip>

                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field label="Numero" variant="solo" color="primary"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field label="Dirección" color="primary" variant="solo"></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn class="bg-secondary" prepend-icon="mdi-account-plus">Crear perfil</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>

</script>

<style lang="scss" scoped></style>