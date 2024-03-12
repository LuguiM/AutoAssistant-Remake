<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Crear Pilotos</h3>
        </div>

      <div class="d-flex justify-center">
        <v-card width="500" class="bg-greyDark">
            <v-card-title>Piloto</v-card-title>

            <v-card-text>
                <v-text-field label="Nombre" variant="solo-filled" hide-details="auto"></v-text-field>
            </v-card-text>
            <v-card-text>
                <v-textarea label="Descripcion" variant="solo-filled" hide-details="auto"></v-textarea>
            </v-card-text>
        </v-card>
      </div>  
    </v-container>
</template>

<script>

</script>

<style>
.v-label.v-field-label{
    color:#1279C1 !important;
    
}
</style>

