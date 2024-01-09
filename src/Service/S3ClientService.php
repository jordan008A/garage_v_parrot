<?php

namespace App\Service;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3ClientService
{
  private $s3Client;
  private $bucketName;

  public function __construct()
  {
    $this->s3Client = new S3Client([
      'version'     => 'latest',
      'region'      => 'eu-west-3',
      'credentials' => [
        'key'    => $_SERVER['AWS_ACCESS_KEY_ID'],
        'secret' => $_SERVER['AWS_SECRET_ACCESS_KEY'],
      ],
    ]);

    $this->bucketName = $_SERVER['AWS_BUCKET'];
  }

  public function uploadFile($filePath, $keyName)
  {
    try {
      $s3Key = 'img/uploads/' . $keyName;
  
      $result = $this->s3Client->putObject([
        'Bucket'     => $this->bucketName,
        'Key'        => $s3Key,
        'SourceFile' => $filePath,
      ]);
  
      return $result;
    } catch (AwsException $e) {
      error_log('Erreur lors de l\'upload sur S3: ' . $e->getMessage());
      throw $e;
    }
  }
  

  public function getFileUrl($keyName)
  {
    try {
      $cmd = $this->s3Client->getCommand('GetObject', [
        'Bucket' => $this->bucketName,
        'Key'    => $keyName
      ]);

      $request = $this->s3Client->createPresignedRequest($cmd, '+20 minutes');

      return (string) $request->getUri();
    } catch (AwsException $e) {
      throw new \Exception('Erreur lors de la génération de l\'URL: ' . $e->getMessage());
    }
  }

  public function deleteFile($keyName)
  {
    $s3Key = 'img/uploads/' . $keyName;

    try {
      $result = $this->s3Client->deleteObject([
        'Bucket' => $this->bucketName,
        'Key'    => $s3Key,
      ]);

      return $result;
    } catch (AwsException $e) {
      throw new \Exception('Erreur lors de la suppression du fichier: ' . $e->getMessage());
    }
  }
}