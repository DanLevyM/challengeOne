
variable "movie_name" {
  type = string
  default = "V pour Vendetta"
}

resource null_resource rs_name_1 {
  provisioner "local-exec" {
    command = "echo ${var.movie_name} >> film.txt"
  }
}
output "file_created" {
  value = "Fichier film.txt crée"
}