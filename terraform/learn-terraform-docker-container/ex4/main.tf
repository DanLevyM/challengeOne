variable "movies_name" {
  type = list(string)
  default = [ "AAA", "V pour Vendetta", "Le cinquième élément" ]
}

resource null_resource rs_name_4 {
  count = length(var.movies_name)

  triggers = {
    "foo" = element(var.movies_name, count.index)
  }

  provisioner "local-exec" {
    command = "echo ${var.movies_name[count.index]} >> film.txt"
  }
}