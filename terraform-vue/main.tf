terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 4.16"
    }
  }
  required_version = ">= 1.2.0"
}

provider "aws" {
  region = var.region
}

resource "aws_instance" "challenge-one-vue-instance" {
  ami                  = var.ami_id
  instance_type        = "t2.micro"
  key_name             = var.ami_key_pair_name
  iam_instance_profile = var.iam_instance_profile
  
  tags = {
    Name = var.instance_name
  }
  
  security_groups      = ["${aws_security_group.ingress-all-test.id}"]
	user_data = file("script.sh")
}

resource "aws_ecs_cluster" "challenge-one-vue-cluster" {
  name = var.cluster_name
}

resource "aws_default_vpc" "default" {
  tags = {
    Name = "Default VPC"
  }
}

resource "aws_default_subnet" "default_az1" {
  availability_zone = "eu-west-3a"

  tags = {
    Name = "Default subnet for eu-west-3"
  }
}

