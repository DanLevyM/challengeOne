variable "ssh_host" {}
variable "ssh_user" {}
variable "ssh_password" {}

resource "null_resource" "ssh_command" {
  connection {
    type        = "ssh"
    host        = var.ssh_host
    user        = var.ssh_user
    password    = var.ssh_password
  }

  provisioner "remote-exec" {
    inline = [
      "echo 'hi, World!' > hello.txt",
    ]
  }
}
