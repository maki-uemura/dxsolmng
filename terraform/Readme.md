# base-source terraform

## Table of Contents
* [Requirements](##requirements)
* [Setup](##setup)
* [Usage](##usage)
* [References](##references)
* [Memos](##memos)

## Requirements
- Mac OS
- Terraform CLI 1.1.0

## Setup
### Install terraform CLI

Install tfenv
```
brew install tfenv
```

Install terraform cli
```
tfenv install 1.1.0
tfenv use 1.1.0
```


### Set AWS Credentials
Set your aws credentails to the environment.
```
export AWS_ACCESS_KEY_ID=${YOUR_ACCESS_KEY_ID}
export AWS_SECRET_ACCESS_KEY=${YOUR_SECRET_ACCESS_KEY}
export AWS_DEFAULT_REGION=ap-northeast-1
```

### Create S3 bucket to store tfstate
To store tfstate at S3, we need to create S3 bucket.

### Confirm tfvars
Some variables are set at "terraform.tfvars" and it needs to be checked before running terraform.
To generate passport public key and private key we need to run this command

### Please replace <<PLACEHOLDER>> with the appropriate value.
Finding <<PLACEHOLDER>> in the codebase and replace it with the appropriate value.

```
php artisan passport:keys
```

```
database_password = "XXXX"
master_key = "base64:XXXX"
docker_username = "XXX"
docker_password = "XXXX"
github_token = "XXXXX"
app_key = "base64:XXXXX"
passport_private_key = <<EOT
-----BEGIN PRIVATE KEY-----
XXXXX
-----END PRIVATE KEY-----
EOT
passport_public_key = <<EOT
-----BEGIN PUBLIC KEY-----
XXXXX
-----END PUBLIC KEY-----
EOT
```

## Usage

Install dependencies
```
terraform init
```

Create an execution plan
```
terraform plan
```

Apply pre-determined set of actions generated by the ` terraform plan `.
Before apply the script you need to check variables.tf default value to make sure the value is fitable and customize them based on project's spec.
```
terraform apply
```

## Styling

Run linter
```
terraform fmt -recursive
```

Validate whether the configuration is valid
```
terraform validate
```

## References
- [IP architecture](https://www.notion.so/iruuzainc/IP-architecture-85d035693086447c88fcf286f682d21b). This document is for Jitera, but  also follows it.


## Memos
- We aren't managing DNS on terraform currently.
- We're not using workspace feature for switching environment (staging / production), because it's for testing according to [the official document](https://www.terraform.io/docs/state/workspaces.html#when-to-use-multiple-workspaces).
- See [the official best practices](https://www.terraform-best-practices.com/) to keep this project clean and simple.