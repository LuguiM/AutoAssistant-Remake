<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Pefil de la cuenta</h3>
        </div>

        <v-row>
            <v-col cols="12" sm="4" class="d-flex justify-center">
                <v-btn class="bg-primary" prepend-icon="mdi-account-cog">Actualizar Perfil</v-btn>
            </v-col>
            <v-col cols="12" sm="4" class="d-flex justify-center">
                <v-btn class="bg-terceary" prepend-icon="mdi-lock-reset" @click="cambiarContraModal = true">Cambiar
                    contraseña</v-btn>
            </v-col>
            <v-col cols="12" sm="4" class="d-flex justify-center">
                <v-btn class="bg-error" prepend-icon="mdi-account-remove" @click="eliminarPerfilModal = true">
                    Eliminar cuenta
                </v-btn>
            </v-col>
            <v-col cols="12">
                <v-card class="bg-primary">
                    <v-card-title class="text-center text-h5">Informacion del perfil</v-card-title>
                    <v-divider color="black" :thickness="5"></v-divider>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="3">
                                <h4>Nombre:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Kerin Melendez</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Correo electronico:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>mio@gmail.com</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Edad:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>21</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Tipo de cuenta:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Admin</h4>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!--Modal de cambiar contraseña-->
        <v-dialog width="auto" v-model="cambiarContraModal" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Cambiar contraseña</v-card-title>
                <v-card-subtitle class="pt-0">Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerla
                    segura</v-card-subtitle>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>
                    <v-text-field color="primary" label="Contraseña actual"></v-text-field>
                    <v-text-field color="primary" label="Nueva contraseña"></v-text-field>
                    <v-text-field color="primary" label="Repetir nueva contraseña"></v-text-field>
                </v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="cambiarContraModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--Modal de Eliminar-->
        <v-dialog width="auto" v-model="eliminarPerfilModal" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Cuenta</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>¿Esta seguro de querer eliminar tu cuenta?</v-card-text>
                <v-card-text class="pt-0">Esta accion sera irreversible y todos tus datos <br> se borraran
                    permanentemente</v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary" @click="confirmarEliminar = true">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarPerfilModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="auto" v-model="confirmarEliminar" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Cuenta</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>Ingrese su contraseña para eliminar su cuenta</v-card-text>
                <v-card-text class="pt-0">
                    <v-text-field color="primary" label="Contraseña"></v-text-field>
                </v-card-text>
                <v-card-actions class="mt-3">
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarPerfil">Eliminar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';


let eliminarPerfilModal = ref(false);
const confirmarEliminar = ref(false);
const cambiarContraModal = ref(false);

const eliminarPerfil = () => {
    confirmarEliminar.value = false
    eliminarPerfilModal.value = false
}

</script>

<style lang="scss" scoped></style>