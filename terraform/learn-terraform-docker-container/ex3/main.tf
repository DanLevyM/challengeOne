variable "movies_name" {
  type = map
  default = {
    "Hallowenn" = "Firm horreur"
    "Infinity War" = "Film action"
  }
}

resource null_resource rs_name_1 {
  for_each = var.movies_name

  provisioner "local-exec" {
    command = "echo ${each.key} type: ${each.value} >> films.txt"
  }
}

output "file_created" {
  value = "Fichier films.txt crée"
}
